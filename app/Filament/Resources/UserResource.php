<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section as FormSection;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form->schema([
            FormSection::make('User Details')->schema([
                TextInput::make('name')->required()->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        table: 'users',
                        column: 'email',
                        ignoreRecord: true
                    ),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->rule(Password::default())
                    ->visibleOn('create'),

                Toggle::make('is_active'),

                CheckboxList::make('roles')
                    ->relationship('roles', 'name')
                    ->columns(2),
            ]),

            FormSection::make('Set New Password')
                ->schema([
                    TextInput::make('new_password')
                        ->nullable()
                        ->password()
                        ->revealable()
                        ->rule(Password::default())
                        ->confirmed(),

                    TextInput::make('new_password_confirmation')
                        ->password()
                        ->revealable(),
                ])
                ->visibleOn('edit'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                ToggleColumn::make('is_active')->onColor('success'),
                TextColumn::make('created_at')->dateTime(
                    timezone: config('app.admin_timezone')
                ),
                TextColumn::make('updated_at')->dateTime(
                    timezone: config('app.admin_timezone')
                ),
                TextColumn::make('last_login_at')->dateTime(
                    timezone: config('app.admin_timezone')
                ),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfolistSection::make('User Details')->schema([
                TextEntry::make('id')
                    ->copyable()
                    ->fontFamily(FontFamily::Mono),
                TextEntry::make('name'),
                TextEntry::make('email')->copyable(),
                TextEntry::make('is_active')
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string => $state
                            ? 'Active'
                            : 'Inactive'
                    )
                    ->color(
                        fn (bool $state): string => $state ? 'success' : 'gray'
                    ),
                TextEntry::make('roles.name'),
            ]),

            InfolistSection::make('Dates')->schema([
                TextEntry::make('created_at')
                    ->dateTime(timezone: config('app.admin_timezone'))
                    ->sinceTooltip(),
                TextEntry::make('updated_at')->dateTime(
                    timezone: config('app.admin_timezone')
                ),
                TextEntry::make('last_login_at')
                    ->dateTime(timezone: config('app.admin_timezone'))
                    ->sinceTooltip(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
