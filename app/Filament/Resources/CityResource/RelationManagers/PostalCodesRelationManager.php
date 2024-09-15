<?php

namespace App\Filament\Resources\CityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PostalCodesRelationManager extends RelationManager
{
    protected static string $relationship = 'postalCodes';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('district_id')
                ->relationship('district', 'name')
                ->required()
                ->options(function (RelationManager $livewire): array {
                    return $livewire
                        ->getOwnerRecord()
                        ->districts()
                        ->pluck('name', 'id')
                        ->toArray();
                }),
            Forms\Components\TextInput::make('name')->maxLength(255)->string(),
            Forms\Components\TextInput::make('code')
                ->required()
                ->maxLength(255)
                ->string()
                ->unique('postal_codes', 'code', ignoreRecord: true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                Tables\Columns\TextColumn::make('district.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('code'),
            ])
            ->filters([
                //
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
