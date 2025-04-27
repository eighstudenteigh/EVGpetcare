<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::dropIfExists('appointment_service_vaccine');
    
    Schema::create('appointment_service_vaccine', function (Blueprint $table) {
        $table->unsignedBigInteger('appointment_service_id');
        $table->unsignedBigInteger('vaccine_type_id');
        $table->primary(['appointment_service_id', 'vaccine_type_id']);
        
        $table->timestamps();
        $table->index('appointment_service_id');
        
        $table->foreign('appointment_service_id')
              ->references('id')
              ->on('appointment_service')
              ->onDelete('cascade')
              ->onUpdate('cascade');
              
        $table->foreign('vaccine_type_id')
              ->references('id')
              ->on('vaccine_types')
              ->onDelete('cascade')
              ->onUpdate('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
