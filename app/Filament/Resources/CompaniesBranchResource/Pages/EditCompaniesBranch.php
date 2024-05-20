<?php

namespace App\Filament\Resources\CompaniesBranchResource\Pages;

use App\Filament\Resources\CompaniesBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompaniesBranch extends EditRecord
{
    protected static string $resource = CompaniesBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
