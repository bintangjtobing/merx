<?php

namespace App\Filament\Resources\WarehousesResource\Pages;

use App\Filament\Resources\WarehousesResource;
use Filament\Actions;
use Filament\Notifications\Notification;

use Filament\Resources\Pages\CreateRecord;

class CreateWarehouses extends CreateRecord
{
    protected static string $resource = WarehousesResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Warehouse Created.')
            ->body('The new warehouse successfully created.');
    }

}