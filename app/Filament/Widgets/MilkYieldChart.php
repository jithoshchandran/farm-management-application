<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class MilkYieldChart extends ChartWidget
{
    protected ?string $heading = 'Milk Yield Chart';

    protected function getData(): array
    {
        $data = \App\Models\MilkProduction::selectRaw('date, sum(total_yield) as total')
            ->where('date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        return [
            'datasets' => [
                [
                    'label' => 'Total Milk Yield (L)',
                    'data' => $data->values(),
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
