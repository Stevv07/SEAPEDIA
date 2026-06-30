<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['bank', 'e-wallet']);
            $table->string('method_name'); // Contoh: "Bank BNI", "OVO"
            $table->string('account_name'); // a.n. E-TechnoCart
            $table->string('account_number'); // nomor rekening / e-wallet
            $table->string('logo_path')->nullable(); // path ke logo, misal: 'images/bni.png'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};