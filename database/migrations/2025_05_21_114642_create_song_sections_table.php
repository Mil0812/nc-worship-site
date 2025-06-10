<?php

use App\Enums\SongSectionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('song_sections', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('section_type', Arr::map(SongSectionType::cases(), fn (SongSectionType $songSectionType)
            => $songSectionType->value))->default(SongSectionType::CHORUS->value);
            $table->integer('order')->default(0);
            $table->text('lyrics');
            $table->text('chords')->nullable();
            $table->foreignUlid('song_id')->constrained('songs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_sections');
    }
};
