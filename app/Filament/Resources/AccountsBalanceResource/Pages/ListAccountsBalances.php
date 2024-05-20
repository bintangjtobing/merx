<?php

namespace App\Filament\Resources\AccountsBalanceResource\Pages;

use App\Filament\Resources\AccountsBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountsBalances extends ListRecords
{
    protected static string $resource = AccountsBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
