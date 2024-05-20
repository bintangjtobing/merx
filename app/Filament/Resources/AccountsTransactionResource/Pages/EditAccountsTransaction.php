<?php

namespace App\Filament\Resources\AccountsTransactionResource\Pages;

use App\Filament\Resources\AccountsTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountsTransaction extends EditRecord
{
    protected static string $resource = AccountsTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
