<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetTypesTable extends Migration
{
    public function up()
    {
        Schema::create('pet_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pet_types');
    }
}
