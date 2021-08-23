<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('seller_id')->constrained('users');
            $table->bigInteger("store_id")->unsigned()->nullable();
            $table->bigInteger("category_id")->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('price')->nullable();
            $table->json('varian')->nullable();
            // $table->integer('stock');
            // $table->json('image'); //store location of image
            $table->integer("rating")->nullable();
            // $table->json("ar_link")->nullable();
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
}
