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
            Schema::create('surgery_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('record_id')->constrained()->onDelete('cascade');
                $table->string('procedure_name');
                $table->string('anesthesia_type');
                $table->string('surgeon_name');
                $table->time('start_time');
                $table->time('end_time');
                $table->text('complications')->nullable();
                $table->text('post_op_instructions');
                $table->text('medications')->nullable();
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surgery_records');
    }
};
