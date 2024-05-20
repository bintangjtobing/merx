<?php

namespace App\Filament\Resources\WarehousesResource\Pages;

use App\Filament\Resources\WarehousesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditWarehouses extends EditRecord
{
    protected static string $resource = WarehousesResource::class;

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
            ->title('Warehouse Updated.')
            ->body('The warehouse successfully updated.');
    }
}