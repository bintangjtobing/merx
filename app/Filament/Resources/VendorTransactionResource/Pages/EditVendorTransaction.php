<?php

namespace App\Filament\Resources\VendorTransactionResource\Pages;

use App\Filament\Resources\VendorTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendorTransaction extends EditRecord
{
    protected static string $resource = VendorTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
