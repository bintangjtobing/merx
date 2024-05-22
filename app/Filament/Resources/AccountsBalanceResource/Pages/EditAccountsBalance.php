<?php

namespace App\Filament\Resources\AccountsBalanceResource\Pages;

use App\Filament\Resources\AccountsBalanceResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAccountsBalance extends EditRecord
{
    protected static string $resource = AccountsBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Account Balance Updated.')
            ->body('The account balance has been successfully updated.');
    }
}