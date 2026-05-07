<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Mail;

// Daily Heat Check
Schedule::call(function () {
    $cows = \App\Models\Cow::whereDate('next_expected_heat', today())->get();
    if ($cows->isNotEmpty()) {
        // In production: Mail::to('manager@bovine.com')->send(new HeatAlert($cows));
        logger('Heat Alert: ' . $cows->pluck('tag_number')->implode(', '));
    }
})->dailyAt('08:00');

// Inventory Alert
Schedule::call(function () {
    $lowStock = \App\Models\Feed::where('quantity_in_stock', '<', 100)->get();
    if ($lowStock->isNotEmpty()) {
        // In production: Notification::send(...)
        logger('Low Feed Stock: ' . $lowStock->pluck('name')->implode(', '));
    }
})->dailyAt('09:00');

// Vaccination Reminder
Schedule::call(function () {
    $dueSoon = \App\Models\Vaccination::whereDate('next_due_date', today()->addDays(3))->get();
    if ($dueSoon->count() > 0) {
        logger('Vaccination Reminder: ' . $dueSoon->count() . ' cows due in 3 days.');
    }
})->dailyAt('10:00');

// Daily Farm Summary Report
Schedule::command('farm:send-summary pramod.thalakurissi@gmail.com')->dailyAt('22:00');
