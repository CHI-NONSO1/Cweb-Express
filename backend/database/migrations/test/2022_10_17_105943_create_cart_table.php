<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id('cartid')->unique();
            $table->string('productid');
            $table->string('product_name');
            $table->string('price');
            $table->text('image');
            $table->string('category');
            $table->string('quantity');
            $table->string('user_id');
            $table->bigInteger('total_qty')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->string('description', 1000)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
};
