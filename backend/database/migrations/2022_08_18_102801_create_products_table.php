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
        Schema::create('products', function (Blueprint $table) {
            $table->id('productid')->unique();
            $table->string('product_name');
            $table->string('price');
            $table->text('image');
            $table->string('category');
            $table->string('quantity');
            $table->string('description', 1000)->nullable();
            $table->string('rating')->nullable();
            $table->string('feature_image')->nullable();
            $table->string('user_id');
            $table->foreign('user_id')->references('biz_id')->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
