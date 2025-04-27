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
        Schema::table('service_vaccine_pricing', function (Blueprint $table) {
            // Just add the new composite unique key
            $table->unique(['service_id', 'vaccine_type_id', 'pet_type_id'], 
                  'service_vaccine_pricing_composite_unique');
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
