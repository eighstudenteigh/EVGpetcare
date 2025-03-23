<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('service_type'); // ✅ Remove service_type column
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->json('service_type')->nullable(); // ✅ Add back service_type if needed
        });
    }
};
