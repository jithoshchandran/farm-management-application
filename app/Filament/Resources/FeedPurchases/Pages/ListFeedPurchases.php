<?php

namespace App\Filament\Resources\FeedPurchases\Pages;

use App\Filament\Resources\FeedPurchases\FeedPurchaseResource;
use App\Services\FeedPurchaseReportService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;

class ListFeedPurchases extends ListRecords
{
    protected static string $resource = FeedPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('exportFeedPurchaseExcel')
                ->label('Export Excel')
                ->icon('heroicon-o-table-cells')
                ->color('success')
                ->modalHeading('Feed Purchase Monthly Report')
                ->modalSubmitActionLabel('Download Excel')
                ->form(self::reportForm())
                ->action(fn (array $data) => app(FeedPurchaseReportService::class)
                    ->downloadExcel($data['month'], $data['comparison_month'])),
            Action::make('exportFeedPurchasePdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('gray')
                ->modalHeading('Feed Purchase Monthly Report')
                ->modalSubmitActionLabel('Download PDF')
                ->form(self::reportForm())
                ->action(fn (array $data) => app(FeedPurchaseReportService::class)
                    ->downloadPdf($data['month'], $data['comparison_month'])),
        ];
    }

    private static function reportForm(): array
    {
        return [
            DatePicker::make('month')
                ->label('Report Month')
                ->default(now())
                ->required(),
            DatePicker::make('comparison_month')
                ->label('Compare With Month')
                ->default(now()->subMonth())
                ->required(),
        ];
    }
}
