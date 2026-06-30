<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke orders
            $table->string('order_code');
            
            // Foreign key ke products
            $table->string('code_product');

            // Detail item
            $table->integer('quantity');
            $table->decimal('subtotal', 12, 2);

            $table->timestamps();

            // Relasi ke tabel orders (kode pesanan sebagai primary key)
            $table->foreign('order_code')
                  ->references('order_code')
                  ->on('orders')
                  ->onDelete('cascade');

            // Relasi ke tabel products (kode produk sebagai primary key)
            $table->foreign('code_product')
                  ->references('code_product')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};