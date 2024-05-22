<?php

namespace App\Filament\Resources\VendorContactResource\Pages;

use App\Filament\Resources\VendorContactResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditVendorContact extends EditRecord
{
    protected static string $resource = VendorContactResource::class;

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
            ->title('Vendor Contact Updated.')
            ->body('The vendor contact details have been successfully updated.');
    }
}