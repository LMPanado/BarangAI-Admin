<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // residents — filtered by gender, voter, age; sorted by name/date
        DB::statement('CREATE INDEX IF NOT EXISTS idx_residents_created_at ON residents (created_at DESC)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_residents_last_name  ON residents (last_name)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_residents_gender     ON residents (gender)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_residents_is_voter   ON residents (is_voter)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_residents_age        ON residents (age)');

        // document_requests — filtered by status, source; sorted by date
        DB::statement('CREATE INDEX IF NOT EXISTS idx_doc_requests_status     ON document_requests (status)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_doc_requests_source     ON document_requests (source)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_doc_requests_created_at ON document_requests (created_at DESC)');

        // complaints — filtered by status, severity; sorted by date
        DB::statement('CREATE INDEX IF NOT EXISTS idx_complaints_status     ON complaints (status)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_complaints_severity   ON complaints (severity)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_complaints_created_at ON complaints (created_at DESC)');

        // feedback — filtered by sentiment; sorted by date
        DB::statement('CREATE INDEX IF NOT EXISTS idx_feedback_sentiment  ON feedback (sentiment)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_feedback_created_at ON feedback (created_at DESC)');

        // schedules — filtered by date
        DB::statement('CREATE INDEX IF NOT EXISTS idx_schedules_date ON schedules (schedule_date)');

        // announcements — sorted by date
        DB::statement('CREATE INDEX IF NOT EXISTS idx_announcements_created_at ON announcements (created_at DESC)');

        // audit_logs — sorted by date
        DB::statement('CREATE INDEX IF NOT EXISTS idx_audit_logs_created_at ON audit_logs (created_at DESC)');

        // users — filtered by role and verification_status
        DB::statement('CREATE INDEX IF NOT EXISTS idx_users_role                ON users (role)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_users_verification_status ON users (verification_status)');
    }

    public function down(): void
    {
        foreach ([
            'idx_residents_created_at', 'idx_residents_last_name', 'idx_residents_gender',
            'idx_residents_is_voter', 'idx_residents_age',
            'idx_doc_requests_status', 'idx_doc_requests_source', 'idx_doc_requests_created_at',
            'idx_complaints_status', 'idx_complaints_severity', 'idx_complaints_created_at',
            'idx_feedback_sentiment', 'idx_feedback_created_at',
            'idx_schedules_date', 'idx_announcements_created_at', 'idx_audit_logs_created_at',
            'idx_users_role', 'idx_users_verification_status',
        ] as $index) {
            DB::statement("DROP INDEX IF EXISTS {$index}");
        }
    }
};
