<?php

namespace App\Filament\Resources\CompaniesBranchResource\Pages;

use App\Filament\Resources\CompaniesBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCompaniesBranch extends ViewRecord
{
    protected static string $resource = CompaniesBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
