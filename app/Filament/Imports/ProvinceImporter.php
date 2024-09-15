<?php

namespace App\Filament\Imports;

use App\Models\Province;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProvinceImporter extends Importer
{
    protected static ?string $model = Province::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('name')
                ->guess(['prov_name'])
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required', 'unique:provinces,code']),
        ];
    }

    public function resolveRecord(): ?Province
    {
        return Province::firstOrNew(
            [
                'id' => $this->data['id'],
            ],
            [
                'name' => $this->data['name'],
                'code' => $this->data['code'],
            ]
        );
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body =
            'Your province import has completed and '.
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
