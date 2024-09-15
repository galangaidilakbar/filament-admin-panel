<?php

namespace App\Filament\Resources\ProvinceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DistrictsRelationManager extends RelationManager
{
    protected static string $relationship = 'districts';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('city_id')
                ->relationship('city', 'name')
                ->required()
                ->options(function (RelationManager $livewire): array {
                    return $livewire
                        ->getOwnerRecord()
                        ->cities()
                        ->pluck('name', 'id')
                        ->toArray();
                }),
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('code')
                ->required()
                ->rules(['unique:districts,code'])
                ->maxLength(255),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
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
