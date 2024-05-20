<?php

namespace App\Filament\Resources\AccountsBalanceResource\Pages;

use App\Filament\Resources\AccountsBalanceResource;
use Filament\Actions;
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
}
