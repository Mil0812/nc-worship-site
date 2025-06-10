<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('song_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'song_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favourites');
    }
};
