<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'status',
        'image'
    ];

    /*
     * Создание нового продукта
     *
     * @param  array  $data
     * @return \App\Models\Product
     */
    public static function createProduct(array $data)
    {
        // Получаем название продукта
    $query = $data['name'] ?? 'product';
    $key = 'Ck236-dT41svCXU7X0tHbfGI08o5c_etxUUk60GR53U';

    // Запрос к Unsplash API
    $response = Http::withHeaders([
        'Authorization' => 'Client-ID ' . $key
    ])->get('https://api.unsplash.com/photos/random', [
        'query' => $query
    ]);

    if ($response->successful()) {
        $json = $response->json();
        // 🪵 Логируем весь ответ от Unsplash
    \Log::info('Unsplash JSON response:', $json);

        $data['image'] = $json['urls']['small'] ?? ''; // берём маленькую картинку
    } else {
        $data['image'] = ''; // fallback если запрос не сработал
        \Log::error('Unsplash request failed', ['status' => $response->status()]);
    }

        return self::create($data);
    }

    /*
    * Получение информации о продукте
    *
    * @return array
    */
    public function getInfo(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'status' => $this->status,
            'image' => $this->image,
        ];
    }

    /*
     * Обновление статуса продукта
     * 
     * @param  string  $status
     * @return \App\Models\Product
     */
    public function updateStatus(string $status)
    {
        $this->update(['status' => $status]);
        return $this;
    }

    /*
     * Обновление количества на складе
     * 
     * @param  int  $quantity
     * @return \App\Models\Product
     */
    public function updateStock(int $quantity)
    {
        $this->update(['stock' => $quantity]);
        return $this;
    }

    /*
     * Уменьшение количества на складе
     * 
     * @param  int  $quantity
     * @return bool
     */
    public function decreaseStock(int $quantity)
    {
        if ($this->stock >= $quantity) {
            $this->update(['stock' => $this->stock - $quantity]);
            return true;
        }
        return false;
    }

    /*
     * Увеличение количества на складе
     * 
     * @param  int  $quantity
     * @return \App\Models\Product
     */
    public function increaseStock(int $quantity)
    {
        $this->update(['stock' => $this->stock + $quantity]);
        return $this;
    }

    /*
     * Проверка наличия на складе
     * 
     * @param  int  $quantity
     * @return bool
     */
    public function isInStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }

    /*
     * Обновление цены
     * 
     * @param  float  $price
     * @return \App\Models\Product
     */
    public function updatePrice(float $price)
    {
        $this->update(['price' => $price]);
        return $this;
    }

    // Отношение с заказами
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
