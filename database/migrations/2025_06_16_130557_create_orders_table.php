<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_code')->primary(); // Kode unik pesanan
            $table->unsignedBigInteger('user_id');    // Relasi ke tabel users
            $table->unsignedBigInteger('payment_id'); // Relasi ke tabel payments

            $table->enum('status', ['waiting', 'processing', 'sent', 'complete', 'rejected'])->default('waiting');
            $table->decimal('total_price', 12, 2);
            $table->string('payment_proof')->nullable(); // File bukti bayar

            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Foreign key ke tabel payments
            $table->foreign('payment_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('restrict'); // Hindari penghapusan data pembayaran yang sedang digunakan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};