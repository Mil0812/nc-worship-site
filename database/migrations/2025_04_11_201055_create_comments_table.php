<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->ulidMorphs('commentable');
            $table->text('content');
            $table->ulid('parent_id')->nullable();
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table) {
            // Додаємо зовнішній ключ після створення таблиці
            $table->foreign('parent_id')
                ->references('id')
                ->on('comments')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
