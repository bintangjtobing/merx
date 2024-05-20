<?php

namespace App\Filament\Resources\CompaniesDepartmentResource\Pages;

use App\Filament\Resources\CompaniesDepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompaniesDepartments extends ListRecords
{
    protected static string $resource = CompaniesDepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
