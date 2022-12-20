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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orderid')->unique();
            $table->string('fullname');
            $table->string('phoneno');
            $table->string('email');
            $table->string('product_name');
            $table->string('address');
            $table->string('tracking_id');
            $table->string('price');
            $table->string('product_id');
            $table->text('image');
            $table->string('category');
            $table->string('quantity');
            $table->string('description', 1000)->nullable();
            $table->string('biz_name')->nullable();
            $table->string('total_price');
            $table->string('total_qty');
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
        Schema::dropIfExists('orders');
    }
};
