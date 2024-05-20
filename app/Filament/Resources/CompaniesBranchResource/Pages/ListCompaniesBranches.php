<?php

namespace App\Filament\Resources\CompaniesBranchResource\Pages;

use App\Filament\Resources\CompaniesBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompaniesBranches extends ListRecords
{
    protected static string $resource = CompaniesBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
