<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories_products', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade'); 
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('categories_products');
    }
};
