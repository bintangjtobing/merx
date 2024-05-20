<?php

namespace App\Filament\Resources\AccountsBalanceResource\Pages;

use App\Filament\Resources\AccountsBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAccountsBalance extends ViewRecord
{
    protected static string $resource = AccountsBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
