<?php

namespace App\Filament\Resources\AccountsTransactionResource\Pages;

use App\Filament\Resources\AccountsTransactionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountsTransaction extends CreateRecord
{
    protected static string $resource = AccountsTransactionResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Account Transaction Created.')
            ->body('The new account transaction has been successfully created.');
    }
}