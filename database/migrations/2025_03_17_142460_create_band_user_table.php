<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('band_user', function (Blueprint $table) {
            $table->foreignUlid('band_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['band_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('band_user');
    }
};
