<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Console\Command;

class PurgeUnverifiedUsers extends Command
{
    protected $signature = 'users:purge-unverified';
    protected $description = 'Delete resident accounts that remain unverified after 30 days';

    public function handle(): void
    {
        $cutoff = now()->subDays(30);

        $users = User::where('role', User::ROLE_RESIDENT)
            ->where('verification_status', '!=', 'verified')
            ->where('created_at', '<', $cutoff)
            ->get();

        foreach ($users as $user) {
            AuditLogger::log(
                'deleted',
                'User',
                $user->last_name . ', ' . $user->first_name . ' — auto-purged (unverified 30d)',
                $user->id
            );
            $user->delete();
        }

        $this->info("Purged {$users->count()} unverified user(s).");
    }
}
