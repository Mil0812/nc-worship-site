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
        Schema::table('tutorials', function (Blueprint $table) {
            $table->string('instrument_id', 26)->nullable()->change();
            $table->string('song_id', 26)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutorials', function (Blueprint $table) {
            $table->foreignUlid('instrument_id')->nullable()->change();
            $table->foreignUlid('song_id')->change();
        });
    }
};
