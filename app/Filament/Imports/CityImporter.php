<?php

namespace App\Filament\Imports;

use App\Models\City;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CityImporter extends Importer
{
    protected static ?string $model = City::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->requiredMapping()
                ->rules(['required', 'integer']),
            ImportColumn::make('province')
                ->requiredMapping()
                ->guess(['prov_id'])
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('name')
                ->guess(['city_name'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required', 'max:255', 'unique:cities,code']),
        ];
    }

    public function resolveRecord(): ?City
    {
        return City::firstOrNew(
            [
                'id' => $this->data['id'],
            ],
            [
                'code' => $this->data['code'],
                'province_id' => $this->data['province'],
                'name' => $this->data['name'],
            ]
        );
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body =
            'Your city import has completed and '.
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
