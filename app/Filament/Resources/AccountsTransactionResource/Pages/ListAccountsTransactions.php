<?php

namespace App\Filament\Resources\AccountsTransactionResource\Pages;

use App\Filament\Resources\AccountsTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountsTransactions extends ListRecords
{
    protected static string $resource = AccountsTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
