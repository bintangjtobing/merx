<?php

namespace App\Filament\Resources\AccountsBalanceResource\Pages;

use App\Filament\Resources\AccountsBalanceResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountsBalance extends CreateRecord
{
    protected static string $resource = AccountsBalanceResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Account Balance Created.')
            ->body('The new account balance has been successfully created.');
    }
}