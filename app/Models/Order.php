<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'product_id',
        'quantity',
        'discount',
        'total',
        'status',
        'payment_status',
        'shipping_status',
        'shipping_address'
    ];

    /*
     * Создание нового заказа
     * @param  array  $data
     * @return \App\Models\Order
     */
    public static function createOrder(array $data)
    {
        $product = Product::findOrFail($data['product_id']);
        
        if (!$product->isInStock($data['quantity'])) {
            return false;
        }

        $total = ($product->price * $data['quantity']) - ($data['discount'] ?? 0);
        $data['total'] = $total;

        $order = self::create($data);
        $product->decreaseStock($data['quantity']);

        return $order;
    }

    /*
    * Получение информации о заказе
    *
    * @return array
    */
    public function getInfo(): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'product' => $this->product->getInfo(),
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'total' => $this->total,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'shipping_status' => $this->shipping_status,
            'shipping_address' => $this->shipping_address,
        ];
    }

    /*
    * Обновление статуса заказа
    *
    * @param  string  $status
    * @return \App\Models\Order
    */
    public function updateStatus(string $status)
    {
        $this->update(['status' => $status]);
        return $this;
    }

    /*
    * Обновление статуса оплаты
    *
    * @param  string  $status
    * @return \App\Models\Order
    */
    public function updatePaymentStatus(string $status)
    {
        $this->update(['payment_status' => $status]);
        return $this;
    }

    /*
    * Обновление статуса доставки
    *
    * @param  string  $status
    * @return \App\Models\Order
    */
    public function updateShippingStatus(string $status)
    {
        $this->update(['shipping_status' => $status]);
        return $this;
    }

    /*
    * Применение скидки
    *
    * @param  float  $discount
    * @return \App\Models\Order
    */
    public function applyDiscount(float $discount)
    {
        $this->update([
            'discount' => $discount,
            'total' => ($this->product->price * $this->quantity) - $discount
        ]);
        return $this;
    }

    /*
    * Изменение количества товара в заказе
    * @param  int  $quantity
    * @return \App\Models\Order
    */
    public function updateQuantity(int $quantity)
    {
        $product = $this->product;
        $oldQuantity = $this->quantity;
        
        $stockDifference = $quantity - $oldQuantity;
        if ($stockDifference > 0 && !$product->isInStock($stockDifference)) {
            return false;
        }

        if ($stockDifference > 0) {
            $product->decreaseStock($stockDifference);
        } else {
            $product->increaseStock(abs($stockDifference));
        }

        $this->update([
            'quantity' => $quantity,
            'total' => ($product->price * $quantity) - $this->discount
        ]);

        return $this;
    }

    /*
    * Отмена заказа
    *
    * @return \App\Models\Order
    */
    public function cancel()
    {
        $this->product->increaseStock($this->quantity);
        $this->update([
            'status' => 'cancelled',
            'payment_status' => 'cancelled',
            'shipping_status' => 'cancelled'
        ]);
        return $this;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
