<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales_reports', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('product_code');
            $table->string('product');
            $table->string('category');
            $table->string('merk');
            $table->integer('piece');
            $table->decimal('price_per_piece', 12, 2);
            $table->date('date');
            $table->timestamps();

            // Foreign key ke orders
            $table->foreign('order_code')->references('order_code')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('sales_reports');
    }
};
