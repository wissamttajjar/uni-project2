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
            $table->unsignedInteger("category_id");
            $table->unsignedInteger("owner_id");
            $table->string("name" , 20);
            $table->integer("main_price");
            $table->integer("price1");
            $table->string("date1" , 20);
            $table->integer("price2");
            $table->string("date2" , 20);
            $table->integer("price3");
            $table->string("date3" , 20);
            $table->integer("quantity");
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
