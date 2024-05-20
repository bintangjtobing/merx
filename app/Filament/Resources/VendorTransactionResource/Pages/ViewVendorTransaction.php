<?php

namespace App\Filament\Resources\VendorTransactionResource\Pages;

use App\Filament\Resources\VendorTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVendorTransaction extends ViewRecord
{
    protected static string $resource = VendorTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
