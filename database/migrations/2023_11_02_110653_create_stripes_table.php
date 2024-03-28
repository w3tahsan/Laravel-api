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
        Schema::create('stripes', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('charge');
            $table->integer('discount');
            $table->integer('total');
            $table->integer('ship_check');
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->integer('country');
            $table->integer('city');
            $table->integer('zip');
            $table->string('company')->nullable();
            $table->string('address');
            $table->string('notes')->nullable();
            $table->string('ship_fname')->nullable();
            $table->string('ship_lname')->nullable();
            $table->string('ship_email')->nullable();
            $table->string('ship_phone')->nullable();
            $table->integer('ship_country')->nullable();
            $table->integer('ship_city')->nullable();
            $table->integer('ship_zip')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('ship_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripes');
    }
};