<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE song_sections DROP CONSTRAINT song_sections_section_type_check');
        DB::statement("ALTER TABLE song_sections ADD CONSTRAINT song_sections_section_type_check CHECK (section_type IN ('verse', 'verse1', 'verse2', 'verse3', 'verse4', 'chorus', 'chorus2', 'bridge', 'bridge2', 'pre_chorus', 'pre_chorus2', 'intro', 'outro', 'instrumental', 'insert'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE song_sections DROP CONSTRAINT song_sections_section_type_check');
        DB::statement("ALTER TABLE song_sections ADD CONSTRAINT song_sections_section_type_check CHECK (section_type IN ('verse1', 'verse2', 'verse3', 'chorus', 'bridge', 'pre_chorus', 'intro'))");
    }
};
