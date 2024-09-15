<?php

namespace App\Filament\Resources\PostalCodeResource\Pages;

use App\Filament\Resources\PostalCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostalCodes extends ListRecords
{
    protected static string $resource = PostalCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
