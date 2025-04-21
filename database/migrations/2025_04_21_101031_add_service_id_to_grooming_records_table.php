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
        Schema::table('grooming_records', function (Blueprint $table) {
            // Add the service_id column as a foreign key
            $table->foreignId('service_id')
                  ->nullable()
                  ->after('pet_id') // Places it after pet_id in the table
                  ->constrained('services')
                  ->onDelete('set null'); // Set to null if service is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grooming_records', function (Blueprint $table) {
            //
        });
    }
};
