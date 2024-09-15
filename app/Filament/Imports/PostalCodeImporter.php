<?php

namespace App\Filament\Imports;

use App\Models\PostalCode;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PostalCodeImporter extends Importer
{
    protected static ?string $model = PostalCode::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->requiredMapping()
                ->rules(['required', 'integer']),
            ImportColumn::make('district')
                ->requiredMapping()
                ->guess(['dis_id'])
                ->relationship()
                ->rules(['required']),
            // ImportColumn::make('name')->rules(['max:255']),
            ImportColumn::make('code')
                ->requiredMapping()
                ->guess(['postal_code'])
                ->rules(['required', 'max:255', 'unique:postal_codes,code']),
        ];
    }

    public function resolveRecord(): ?PostalCode
    {
        return PostalCode::firstOrNew(
            [
                'id' => $this->data['id'],
            ],
            [
                'district_id' => $this->data['district'],
                // 'name' => $this->data['name'],
                'code' => $this->data['code'],
            ]
        );
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body =
            'Your postal code import has completed and '.
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
