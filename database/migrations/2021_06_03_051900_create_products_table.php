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
            $table->string('name');
            $table->string('description');
            $table->integer('price');
            $table->string('color');
            $table->integer('stock');
            $table->string('image'); //store location of image
            $table->integer("rating")->nullable();
            $table->longText("ar_link")->nullable();
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
