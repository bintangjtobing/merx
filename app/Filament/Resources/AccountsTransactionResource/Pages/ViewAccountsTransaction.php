<?php

namespace App\Filament\Resources\AccountsTransactionResource\Pages;

use App\Filament\Resources\AccountsTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAccountsTransaction extends ViewRecord
{
    protected static string $resource = AccountsTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
