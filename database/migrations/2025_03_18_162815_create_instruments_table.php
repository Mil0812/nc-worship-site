<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->char('name', length: 30)->unique();
            $table->string('icon')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
