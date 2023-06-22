<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if(!Schema::hasTable('go_load_up_services')) {
            Schema::create('go_load_up_services', function (Blueprint $table) {
                $table->id();
                $table->integer('code')->unique();
                $table->json('product_variant_ids');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('go_load_up_services');
    }
};
