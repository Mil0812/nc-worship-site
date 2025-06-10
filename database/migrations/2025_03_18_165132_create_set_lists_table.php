<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('set_lists', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->foreignUlid('band_id')->constrained()->cascadeOnDelete();
            $table->date('performed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('set_lists');
    }
};
