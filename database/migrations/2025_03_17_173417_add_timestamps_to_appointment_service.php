<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('appointment_service', function (Blueprint $table) {
            $table->timestamps(); // ✅ Adds `created_at` & `updated_at`
        });
    }

    public function down()
    {
        Schema::table('appointment_service', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
