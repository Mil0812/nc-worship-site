<?php

use App\Enums\OriginalKey;
use App\Enums\SongType;
use App\Enums\TimeSignature;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->char('name', length: 100)
                ->unique();
            $table->string('slug', 128)->unique();
            $table->string('author', 128)->nullable();
            $table->enum('type', Arr::map(SongType::cases(), fn (SongType $songType) => $songType->value));
            $table->string('image')->nullable();
            $table->enum('original_key', Arr::map(OriginalKey::cases(), fn (OriginalKey $originalKey) => $originalKey->value));
            $table->integer('bpm');
            $table->enum('time_signature', Arr::map(TimeSignature::cases(), fn (TimeSignature $timeSignature) => $timeSignature->value))
                ->nullable();
            $table->string('audio', 2048)->nullable();
            $table->string('meta_title', 128)->nullable();
            $table->string('meta_description', 376)->nullable();
            $table->string('meta_image', 2048)->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
