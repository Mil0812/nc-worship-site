<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_user', function (Blueprint $table) {
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('instrument_id')->constrained()->cascadeOnDelete();

            $table->primary(['user_id', 'instrument_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_user');
    }
};
