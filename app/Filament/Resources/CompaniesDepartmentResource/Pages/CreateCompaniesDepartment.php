<?php

namespace App\Filament\Resources\CompaniesDepartmentResource\Pages;

use App\Filament\Resources\CompaniesDepartmentResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCompaniesDepartment extends CreateRecord
{
    protected static string $resource = CompaniesDepartmentResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Company Department Created.')
            ->body('The new company department has been successfully created.');
    }
}