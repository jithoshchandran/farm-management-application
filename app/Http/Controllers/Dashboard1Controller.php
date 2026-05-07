<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use App\Models\MilkProduction;
use App\Models\Vaccination;
use App\Models\Feed;
use App\Models\FeedAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard1Controller extends Controller
{
    public function index()
    {
        // 1. Summary Statistics
        $totalCows = Cow::where('gender', 'Female')->count();
        $totalBulls = Cow::where('gender', 'Male')->count();
        $totalCalves = Cow::where('dob', '>', now()->subYear())->count();
        $todayYield = MilkProduction::whereDate('date', now())->sum('total_yield');
        
        // 2. Milk Production Overview (Weekly)
        $weeklyProduction = MilkProduction::select(
            DB::raw('DATE(date) as day'),
            DB::raw('SUM(total_yield) as total')
        )
        ->where('date', '>=', now()->subDays(10))
        ->groupBy('day')
        ->orderBy('day', 'ASC')
        ->get();

        $chartLabels = $weeklyProduction->pluck('day')->map(function($date) {
            return date('D', strtotime($date));
        });
        $chartData = $weeklyProduction->pluck('total');
        
        $avgYield = $chartData->avg() ?? 0;
        $trend = 0;
        if ($chartData->count() >= 2) {
            $last = $chartData->last();
            $prev = $chartData->get($chartData->count() - 2);
            if ($prev > 0) {
                $trend = (($last - $prev) / $prev) * 100;
            }
        }

        // 3. Tab Data
        // - Our Cows Tab
        $pregnantCows = Cow::where('status', 'Pregnant')->limit(5)->get();
        $feedSummary = Feed::limit(3)->get();
        $upcomingVaccinations = Vaccination::with('cow')
            ->where('next_due_date', '>=', now())
            ->orderBy('next_due_date', 'ASC')
            ->limit(5)
            ->get();
        
        // Pending Pregnancy Checks (Example: Cows with Heat but no pregnancy check)
        $pendingChecks = Cow::where('status', 'Active')
            ->whereNotNull('last_heat_date')
            ->where('last_heat_date', '<', now()->subDays(21))
            ->count();

        // - Breeding Bulls Tab
        $breedingBulls = Cow::with('breed')->where('gender', 'Male')->limit(6)->get();

        // - Recent Calves Tab
        $recentCalves = Cow::where('dob', '>', now()->subMonths(6))
            ->orderBy('dob', 'DESC')
            ->limit(6)
            ->get();

        return view('dashboard1', compact(
            'totalCows', 'totalBulls', 'totalCalves', 'todayYield',
            'chartLabels', 'chartData', 'avgYield', 'trend',
            'pregnantCows', 'feedSummary', 'upcomingVaccinations', 'pendingChecks',
            'breedingBulls', 'recentCalves'
        ));
    }
}
