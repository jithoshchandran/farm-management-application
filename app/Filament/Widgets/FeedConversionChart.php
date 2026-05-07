<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class FeedConversionChart extends ChartWidget
{
    protected ?string $heading = 'Feed Conversion Chart';

    protected function getData(): array
    {
        // Monthly Feed Costs
        $feedCosts = \App\Models\FeedAllocation::selectRaw("DATE_FORMAT(date, '%Y-%m') as month, sum(cost) as total_cost")
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_cost', 'month');

        // Monthly Milk Yield (Assuming $0.50 per Liter revenue)
        // MySQL date formatting
        $milkRevenue = \App\Models\MilkProduction::selectRaw("DATE_FORMAT(date, '%Y-%m') as month, sum(total_yield) * 0.50 as revenue")
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        // Merge keys to ensure alignment
        $months = $feedCosts->keys()->merge($milkRevenue->keys())->unique()->sort()->values();

        return [
            'datasets' => [
                [
                    'label' => 'Feed Cost ($)',
                    'data' => $months->map(fn($m) => $feedCosts[$m] ?? 0)->toArray(),
                    'borderColor' => '#ef4444', // Red
                ],
                [
                    'label' => 'Milk Revenue (Est $)',
                    'data' => $months->map(fn($m) => $milkRevenue[$m] ?? 0)->toArray(),
                    'borderColor' => '#10b981', // Green
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
