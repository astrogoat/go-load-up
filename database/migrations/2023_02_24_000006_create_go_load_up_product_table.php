<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('go_load_up_product', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_product_variant_id');
            $table->Text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('go_load_up_product');
    }
};
