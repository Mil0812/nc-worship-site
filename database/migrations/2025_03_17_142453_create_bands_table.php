<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bands', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->char('name', length: 30);
            $table->string('image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bands');
    }
};
