<?php

namespace App\Filament\Resources\PaymentReceiptResource\Pages;

use App\Filament\Resources\PaymentReceiptResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPaymentReceipt extends EditRecord
{
    protected static string $resource = PaymentReceiptResource::class;

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
            ->title('Payment Receipt Updated.')
            ->body('The payment receipt details have been successfully updated.');
    }
}