<?php

use App\Models\Schedule;
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
