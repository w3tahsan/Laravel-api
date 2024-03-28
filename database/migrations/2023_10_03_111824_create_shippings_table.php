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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('ship_fname');
            $table->string('ship_lname')->nullable();
            $table->integer('ship_country_id');
            $table->integer('ship_city_id');
            $table->integer('ship_zip');
            $table->string('ship_company')->nullable();
            $table->string('ship_email')->nullable();
            $table->string('ship_phone');
            $table->string('ship_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
