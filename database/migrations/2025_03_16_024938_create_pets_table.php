<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id(); // Default bigIncrements()
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade'); 
            $table->string('name');
            $table->string('type');
            $table->string('breed')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable(); // ✅ Using ENUM
            $table->unsignedInteger('age')->nullable(); // ✅ Unsigned integer for age
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
