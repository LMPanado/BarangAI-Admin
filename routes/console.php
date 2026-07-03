<?php

use App\Models\DocumentRequest;
use App\Models\Schedule;
use App\Models\Resident;
use App\Models\Announcement;
use App\Models\Feedback;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule as Cron;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('schedules:cleanup', function () {
    $past = Schedule::where('schedule_date', '<', Carbon::today())->get();

    foreach ($past as $schedule) {
        if ($schedule->image) {
            Storage::disk('public')->delete($schedule->image);
        }
        $schedule->delete();
    }

    $this->info("Deleted {$past->count()} past schedule(s).");
})->purpose('Delete schedules whose date has passed');

Cron::command('schedules:cleanup')->dailyAt('00:05');

// Permanently delete archived records older than 30 days at midnight
Artisan::command('archive:purge', function () {
    $cutoff = Carbon::now()->subDays(30);

    $residents        = Resident::onlyTrashed()->where('deleted_at', '<=', $cutoff)->get();
    $announcements    = Announcement::onlyTrashed()->where('deleted_at', '<=', $cutoff)->get();
    $feedback         = Feedback::onlyTrashed()->where('deleted_at', '<=', $cutoff)->get();
    $events           = Schedule::onlyTrashed()->where('deleted_at', '<=', $cutoff)->get();
    $documentRequests = DocumentRequest::onlyTrashed()->where('deleted_at', '<=', $cutoff)->get();

    foreach ($announcements as $a) {
        if ($a->image_url) Storage::disk('public')->delete($a->image_url);
        $a->forceDelete();
    }
    foreach ($events as $e) {
        if ($e->image) Storage::disk('public')->delete($e->image);
        $e->forceDelete();
    }
    $residents->each->forceDelete();
    $feedback->each->forceDelete();
    $documentRequests->each->forceDelete();

    $total = $residents->count() + $announcements->count() + $feedback->count() + $events->count() + $documentRequests->count();
    $this->info("Purged {$total} archived record(s) older than 30 days.");
})->purpose('Permanently delete archived records older than 30 days');

Cron::command('archive:purge')->dailyAt('00:10');

Cron::command('users:purge-unverified')->dailyAt('00:15');
