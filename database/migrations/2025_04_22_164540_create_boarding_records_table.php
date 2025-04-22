<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('boarding_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')->constrained()->onDelete('cascade');
            $table->string('kennel_number');
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->text('feeding_schedule');
            $table->text('medications_administered')->nullable();
            $table->text('activity_notes')->nullable();
            $table->text('behavior_notes')->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_records');
    }
};
