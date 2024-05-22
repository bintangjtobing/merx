<?php

namespace App\Filament\Resources\VendorTransactionResource\Pages;

use App\Filament\Resources\VendorTransactionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateVendorTransaction extends CreateRecord
{
    protected static string $resource = VendorTransactionResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Vendor Transaction Created.')
            ->body('The new vendor transaction has been successfully created.');
    }
}