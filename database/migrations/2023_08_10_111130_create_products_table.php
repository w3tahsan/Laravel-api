<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('brand_id')->nullable();
            $table->string('product_name');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('after_discount');
            $table->string('tags')->nullable();
            $table->string('short_desp')->nullable();
            $table->longText('long_desp')->nullable();
            $table->longText('addi_info')->nullable();
            $table->string('preview');
            $table->integer('status')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
