<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('go_load_up_checkbox_combinations', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->Text('label');
            $table->json('products');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('go_load_up_checkbox_combinations');
    }
};
