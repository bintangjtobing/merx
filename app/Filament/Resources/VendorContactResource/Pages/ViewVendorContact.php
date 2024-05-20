<?php

namespace App\Filament\Resources\VendorContactResource\Pages;

use App\Filament\Resources\VendorContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVendorContact extends ViewRecord
{
    protected static string $resource = VendorContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
