<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Service name (e.g., Grooming, Checkup)
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); // Service price
            $table->timestamps();
            $table->string('animal_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
