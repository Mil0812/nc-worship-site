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
        Schema::create('set_list_song', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('set_list_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('song_id')->constrained()->cascadeOnDelete();
            $table->integer('number');
            $table->foreignUlid('leader_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('key', Arr::map(OriginalKey::cases(),
                fn (OriginalKey $originalKey) => $originalKey->value));
            $table->foreignUlid('pad_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['set_list_id', 'song_id']);
            $table->unique(['set_list_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('set_list_song');
    }
};
