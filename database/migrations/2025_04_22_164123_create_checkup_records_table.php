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
        Schema::create('checkup_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 5, 2); // kg
            $table->decimal('temperature', 4, 1); // °C
            $table->integer('heart_rate'); // bpm
            $table->integer('respiratory_rate'); // breaths per minute
            $table->text('diagnosis')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkup_records');
    }
};
