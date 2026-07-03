<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE document_requests ALTER COLUMN created_at SET DEFAULT now()');
        DB::statement('ALTER TABLE document_requests ALTER COLUMN updated_at SET DEFAULT now()');
        DB::statement("UPDATE document_requests SET created_at = COALESCE(updated_at, now()) WHERE created_at IS NULL");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE document_requests ALTER COLUMN created_at DROP DEFAULT');
        DB::statement('ALTER TABLE document_requests ALTER COLUMN updated_at DROP DEFAULT');
    }
};
