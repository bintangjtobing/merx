<?php

namespace App\Filament\Resources\WarehousesResource\Pages;

use App\Filament\Resources\WarehousesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWarehouses extends ViewRecord
{
    protected static string $resource = WarehousesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
