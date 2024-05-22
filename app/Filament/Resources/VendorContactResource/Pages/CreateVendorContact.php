<?php

namespace App\Filament\Resources\VendorContactResource\Pages;

use App\Filament\Resources\VendorContactResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateVendorContact extends CreateRecord
{
    protected static string $resource = VendorContactResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Vendor Contact Created.')
            ->body('The new vendor contact has been successfully created.');
    }
}