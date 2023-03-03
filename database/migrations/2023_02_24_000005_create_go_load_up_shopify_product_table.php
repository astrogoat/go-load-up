<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('go_load_up_shopify_product', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('go_load_up_product_id');
            $table->integer('product_id');
            $table->integer('product_option');
            $table->integer('order');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('go_load_up_shopify_product');
    }
};
