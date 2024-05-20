<?php

namespace App\Filament\Resources\VendorContactResource\Pages;

use App\Filament\Resources\VendorContactResource;
use Filament\Actions;
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
}
