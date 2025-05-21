<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("products", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->decimal("price", 8, 2);
            $table->text('image')->nullable();
            $table->integer("stock");
            $table->string("status")->default("available");
            $table->timestamps();
        });

        \App\Models\Product::create([
            'name' => 'Smartphone X1',
            'description' => 'Latest generation smartphone with advanced features',
            'price' => 999.99,
            'stock' => 50,
            'status' => 'available'
        ]);

        \App\Models\Product::create([
            'name' => 'Wireless Headphones Pro',
            'description' => 'High-quality wireless headphones with noise cancellation',
            'price' => 199.99,
            'stock' => 100,
            'status' => 'available'
        ]);

        \App\Models\Product::create([
            'name' => 'Smart Watch Elite',
            'description' => 'Feature-rich smartwatch with health monitoring',
            'price' => 299.99,
            'stock' => 75,
            'status' => 'available'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("products");
    }
};
