<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('code_product')->primary();  // PK string
            $table->string('name');
            $table->string('category_code', 10);
            $table->string('merk_code', 10);

            // Foreign keys di dalam tabel database
            $table->foreign('category_code')->references('code')->on('categories')->onDelete('cascade');
            $table->foreign('merk_code')->references('code')->on('merks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}