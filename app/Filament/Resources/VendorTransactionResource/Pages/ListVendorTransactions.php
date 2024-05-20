<?php

namespace App\Filament\Resources\VendorTransactionResource\Pages;

use App\Filament\Resources\VendorTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorTransactions extends ListRecords
{
    protected static string $resource = VendorTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
