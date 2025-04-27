<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_vaccine_pricing', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained();
            $table->foreignId('vaccine_type_id')->constrained();
            $table->foreignId('pet_type_id')->nullable()->constrained('pet_types');
            $table->decimal('price', 8, 2)->nullable();

            $table->primary(['service_id', 'vaccine_type_id']);
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
