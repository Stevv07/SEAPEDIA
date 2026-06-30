<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum status
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'pending_payment', 
            'waiting', 
            'processing', 
            'sent', 
            'complete', 
            'rejected'
        ) DEFAULT 'pending_payment'");

        // Tambah kolom expired_at dan ubah payment_id jadi nullable
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('expired_at')->nullable()->after('status');
            $table->unsignedBigInteger('payment_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Kembalikan enum status ke sebelumnya
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'waiting', 
            'processing', 
            'sent', 
            'complete', 
            'rejected'
        ) DEFAULT 'waiting'");

        // Hapus kolom expired_at dan kembalikan payment_id ke non-nullable
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('expired_at');
            $table->unsignedBigInteger('payment_id')->nullable(false)->change();
        });
    }
};
