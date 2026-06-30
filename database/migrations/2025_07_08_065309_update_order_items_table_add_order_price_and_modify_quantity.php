<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Ubah quantity menjadi unsigned
            $table->unsignedInteger('quantity')->change();

            // Tambah kolom price setelah quantity
            $table->decimal('order_price', 12, 2)->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Balikkan quantity jadi signed integer
            $table->integer('quantity')->change();

            // Hapus kolom price
            $table->dropColumn('order_price');
        });
    }
};
