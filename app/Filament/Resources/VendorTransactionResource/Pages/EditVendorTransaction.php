<?php

namespace App\Filament\Resources\VendorTransactionResource\Pages;

use App\Filament\Resources\VendorTransactionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
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

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Vendor Transaction Updated.')
            ->body('The vendor transaction details have been successfully updated.');
    }
}