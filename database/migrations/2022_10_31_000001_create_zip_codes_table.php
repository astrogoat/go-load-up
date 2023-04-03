<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('go_load_up_serviceable_zip_codes', function (Blueprint $table) {
            $table->id();
            $table->string('zip');
            $table->string('name');
            $table->boolean('is_california')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('go_load_up_serviceable_zip_codes');
    }
};
