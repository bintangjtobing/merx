<?php

namespace App\Filament\Resources\CompaniesDepartmentResource\Pages;

use App\Filament\Resources\CompaniesDepartmentResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCompaniesDepartment extends EditRecord
{
    protected static string $resource = CompaniesDepartmentResource::class;

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
            ->title('Company Department Updated.')
            ->body('The company department details have been successfully updated.');
    }
}