<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('go_load_up_cart_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_product_variant_id')->unique();
            $table->json('first_set_of_required_shopify_product_ids')->nullable();
            $table->json('second_set_of_required_shopify_product_ids')->nullable();
            $table->text('error_message');
            $table->timestamps();

            $table->foreign('service_product_variant_id')->references('id')->on('shopify_product_variants')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('go_load_up_cart_requirements');
    }
};
