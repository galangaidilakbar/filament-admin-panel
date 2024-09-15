<?php

namespace App\Filament\Resources\PostalCodeResource\Pages;

use App\Filament\Resources\PostalCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostalCode extends EditRecord
{
    protected static string $resource = PostalCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
