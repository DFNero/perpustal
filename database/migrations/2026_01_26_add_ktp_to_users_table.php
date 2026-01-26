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
        Schema::table('users', function (Blueprint $table) {
            // KTP (ID Card) Number - Required, Unique
            $table->string('ktp_number', 16)->nullable()->after('email');
            $table->unique('ktp_number');

            // KTP Photo Path - Store path to uploaded file in public storage
            $table->string('ktp_photo_path')->nullable()->after('ktp_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['ktp_number']);
            $table->dropColumn('ktp_number');
            $table->dropColumn('ktp_photo_path');
        });
    }
};
