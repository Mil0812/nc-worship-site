<?php

use App\Enums\OriginalKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pads', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->enum('key', Arr::map(OriginalKey::cases(), fn (OriginalKey $originalKey) => $originalKey->value))->nullable();
            $table->string('audio', 2048);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pads');
    }
};
