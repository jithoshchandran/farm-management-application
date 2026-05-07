<?php

namespace App\Filament\Pages;

use App\Models\Cow;
use App\Models\Feed;
use App\Models\MilkProduction;
use App\Models\Vaccination;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\DB;

class Dashboard extends BaseDashboard
{
    protected static string $layout = 'layouts.dashboard-standalone';

    protected string $view = 'dashboard1';

    protected function getViewData(): array
    {
        $totalCows = Cow::where('gender', 'Female')->count();
        $totalBulls = Cow::where('gender', 'Male')->count();
        $totalCalves = Cow::where('dob', '>', now()->subYear())->count();
        $todayYield = MilkProduction::whereDate('date', now())->sum('total_yield');

        $weeklyProduction = MilkProduction::select(
            DB::raw('DATE(date) as day'),
            DB::raw('SUM(total_yield) as total'),
        )
            ->where('date', '>=', now()->subDays(10))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $chartLabels = $weeklyProduction->pluck('day')->map(
            fn (string $date): string => date('D', strtotime($date)),
        );
        $chartData = $weeklyProduction->pluck('total');

        $avgYield = $chartData->avg() ?? 0;
        $trend = 0;

        if ($chartData->count() >= 2) {
            $last = $chartData->last();
            $previous = $chartData->get($chartData->count() - 2);

            if ($previous > 0) {
                $trend = (($last - $previous) / $previous) * 100;
            }
        }

        $pregnantCows = Cow::with('breed')
            ->where('status', 'Pregnant')
            ->limit(5)
            ->get();

        $feedSummary = Feed::limit(3)->get();

        $upcomingVaccinations = Vaccination::with('cow')
            ->where('next_due_date', '>=', now())
            ->orderBy('next_due_date')
            ->limit(5)
            ->get();

        $pendingChecks = Cow::where('status', 'Active')
            ->whereNotNull('last_heat_date')
            ->where('last_heat_date', '<', now()->subDays(21))
            ->count();

        $breedingBulls = Cow::with('breed')
            ->where('gender', 'Male')
            ->limit(6)
            ->get();

        $recentCalves = Cow::where('dob', '>', now()->subMonths(6))
            ->orderByDesc('dob')
            ->limit(6)
            ->get();

        return compact(
            'totalCows',
            'totalBulls',
            'totalCalves',
            'todayYield',
            'chartLabels',
            'chartData',
            'avgYield',
            'trend',
            'pregnantCows',
            'feedSummary',
            'upcomingVaccinations',
            'pendingChecks',
            'breedingBulls',
            'recentCalves',
        );
    }
}
