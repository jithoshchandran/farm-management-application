<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $activeCows = \App\Models\Cow::where('status', 'Active')->count();
        
        // Today's Stats
        $todayMilk = \App\Models\MilkProduction::whereDate('date', today())->sum('total_yield');
        $todayTreatmentExp = \App\Models\Treatment::whereDate('start_date', today())->sum('cost');
        $todayFeedExp = \App\Models\FeedAllocation::whereDate('date', today())->sum('cost');
        $todayGeneralExp = \App\Models\Expense::whereDate('date', today())->sum('amount');
        $totalTodayExp = $todayTreatmentExp + $todayFeedExp + $todayGeneralExp;

        // Monthly Stats
        $monthMilk = \App\Models\MilkProduction::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_yield');
        
        $monthTreatmentExp = \App\Models\Treatment::whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->sum('cost');
        $monthFeedExp = \App\Models\FeedAllocation::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('cost');
        $monthInseminationExp = \App\Models\Insemination::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('cost');
        $monthGeneralExp = \App\Models\Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        $totalMonthExp = $monthTreatmentExp + $monthFeedExp + $monthInseminationExp + $monthGeneralExp;

        // Vaccinations and Calvings
        $monthVaccinations = \App\Models\Vaccination::whereMonth('next_due_date', now()->month)
            ->whereYear('next_due_date', now()->year)
            ->count();
        $monthCalvings = \App\Models\Insemination::whereMonth('expected_calving_date', now()->month)
            ->whereYear('expected_calving_date', now()->year)
            ->count();

        $stats = [
            Stat::make("Today's Total Milk Yield", number_format($todayMilk, 2) . ' L')
                ->description('Total production today')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('success'),

            Stat::make("This Month Total Milk Yield", number_format($monthMilk, 2) . ' L')
                ->description('Total production this month')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),

            Stat::make("Today's Total Expense", '$' . number_format($totalTodayExp, 2))
                ->description('Includes all daily expenses')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('danger'),

            Stat::make("This Month Total Expense", '$' . number_format($totalMonthExp, 2))
                ->description('Total costs this month')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),

            Stat::make('Vaccinations Required (Month)', $monthVaccinations)
                ->description('Next due this month')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color($monthVaccinations > 0 ? 'warning' : 'success'),

            Stat::make('Upcoming Calvings (Month)', $monthCalvings)
                ->description('Expected this month')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('primary'),
            
            Stat::make('Active Herd Size', $activeCows)
                ->description('Total active animals')
                ->color('primary'),

            Stat::make('Today Under Treatment', \App\Models\Treatment::whereDate('start_date', '<=', today())
                ->where(function ($query) {
                    $query->whereDate('end_date', '>=', today())
                        ->orWhereNull('end_date');
                })->count())
                ->description('Cows currently in treatment')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),

            Stat::make('Inseminated Cows', \App\Models\Cow::where('status', 'Inseminated')->count())
                ->description('Total inseminated status')
                ->descriptionIcon('heroicon-m-check-circle') // changed icon to be unique
                ->color('primary'),

            Stat::make('New Borns (This Month)', \App\Models\Cow::where('acquisition_type', 'Born')
                ->whereMonth('dob', now()->month)
                ->whereYear('dob', now()->year)
                ->count())
                ->description('Calves born this month')
                ->descriptionIcon('heroicon-m-gift')
                ->color('success'),
        ];

        // Individual Feed Stock Balance
        $feeds = \App\Models\Feed::all();
        foreach ($feeds as $feed) {
            $stats[] = Stat::make($feed->name . ' Stock', number_format($feed->quantity_in_stock, 2) . ' kg')
                ->description('Current inventory level')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color($feed->quantity_in_stock < 50 ? 'danger' : 'warning');
        }

        return $stats;
    }
}
