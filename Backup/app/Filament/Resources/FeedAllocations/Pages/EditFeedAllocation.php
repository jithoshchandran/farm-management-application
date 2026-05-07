<?php

namespace App\Filament\Resources\FeedAllocations\Pages;

use App\Filament\Resources\FeedAllocations\FeedAllocationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFeedAllocation extends EditRecord
{
    protected static string $resource = FeedAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
