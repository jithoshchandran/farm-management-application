<?php

namespace App\Filament\Resources\FeedAllocations\Pages;

use App\Filament\Resources\FeedAllocations\FeedAllocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeedAllocations extends ListRecords
{
    protected static string $resource = FeedAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
