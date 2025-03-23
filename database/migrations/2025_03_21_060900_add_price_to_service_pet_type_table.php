<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('service_pet_type', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->after('pet_type_id'); // Add price column after pet_type_id
        });
    }

    public function down()
    {
        Schema::table('service_pet_type', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
