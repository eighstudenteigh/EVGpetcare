<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('pet_type_id')->nullable()->after('message');
            $table->unsignedBigInteger('service_id')->nullable()->after('pet_type_id');

            $table->foreign('pet_type_id')->references('id')->on('pet_types')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['pet_type_id']);
            $table->dropForeign(['service_id']);
            $table->dropColumn(['pet_type_id', 'service_id']);
        });
    }
};