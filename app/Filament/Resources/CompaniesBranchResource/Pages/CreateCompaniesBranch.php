<?php

namespace App\Filament\Resources\CompaniesBranchResource\Pages;

use App\Filament\Resources\CompaniesBranchResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCompaniesBranch extends CreateRecord
{
    protected static string $resource = CompaniesBranchResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Company Branch Created.')
            ->body('The new company branch has been successfully created.');
    }
}