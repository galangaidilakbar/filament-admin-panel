<?php

namespace App\Filament\Imports;

use App\Models\District;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DistrictImporter extends Importer
{
    protected static ?string $model = District::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->requiredMapping()
                ->rules(['required', 'integer']),
            ImportColumn::make('city')
                ->requiredMapping()
                ->guess(['city_id'])
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required', 'max:255', 'unique:districts,code']),
        ];
    }

    public function resolveRecord(): ?District
    {
        return District::firstOrNew(
            [
                'id' => $this->data['id'],
            ],
            [
                'city_id' => $this->data['city'],
                'name' => $this->data['name'],
                'code' => $this->data['code'],
            ]
        );
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body =
            'Your district import has completed and '.
            number_format($import->successful_rows).
            ' '.
            str('row')->plural($import->successful_rows).
            ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .=
                ' '.
                number_format($failedRowsCount).
                ' '.
                str('row')->plural($failedRowsCount).
                ' failed to import.';
        }

        return $body;
    }
}
