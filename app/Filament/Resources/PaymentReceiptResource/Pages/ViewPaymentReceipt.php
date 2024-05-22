<?php

namespace App\Filament\Resources\PaymentReceiptResource\Pages;

use App\Filament\Resources\PaymentReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentReceipt extends ViewRecord
{
    protected static string $resource = PaymentReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
