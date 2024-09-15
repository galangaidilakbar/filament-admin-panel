<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\ViewAction::make(), Actions\DeleteAction::make()];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove new_password and new_password_confirmation from $data
        $newPassword = $data['new_password'] ?? null;
        unset($data['new_password'], $data['new_password_confirmation']);

        // Only update password if a new one is provided
        if ($newPassword) {
            $data['password'] = Hash::make($newPassword);
        }

        return $data;
    }
}
