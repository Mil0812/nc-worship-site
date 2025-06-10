<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Change the column type to char(26) first
        // Since notifiable_id is currently bigint, we can cast it to text temporarily
        DB::statement('ALTER TABLE notifications ALTER COLUMN notifiable_id TYPE char(26) USING notifiable_id::char(26)');

        // Step 2: Update notifiable_id to match user IDs (now both are strings, so no cast needed)
        DB::statement('UPDATE notifications n
                       SET notifiable_id = u.id
                       FROM users u
                       WHERE n.notifiable_type = \'App\\Models\\User\'
                       AND n.notifiable_id = u.id::text');

        // Step 3: For any unmatched records, set a default ULID (placeholder)
        DB::statement('UPDATE notifications n
                       SET notifiable_id = \'00000000000000000000000000\' -- Placeholder ULID
                       WHERE notifiable_type = \'App\\Models\\User\'
                       AND NOT EXISTS (
                           SELECT 1 FROM users u WHERE u.id = n.notifiable_id
                       )');

        // Step 4: Set default for future records (optional, requires application logic for ULID generation)
        // Note: PostgreSQL doesn’t support a default ULID, so handle this in your application
    }

    public function down(): void
    {
        // Revert to bigint type
        DB::statement('ALTER TABLE notifications ALTER COLUMN notifiable_id TYPE bigint USING (CASE WHEN notifiable_id IS NOT NULL THEN 0 ELSE 0 END)');
    }
};
