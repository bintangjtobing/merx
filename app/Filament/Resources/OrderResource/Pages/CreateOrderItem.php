<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\OrderItem;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class CreateOrderItem extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getFormSchema(): array
    {
        return [
            Select::make('product_id')
                ->relationship('product', 'name')
                ->required(),
            TextInput::make('quantity')
                ->required()
                ->numeric(),
            TextInput::make('price')
                ->required()
                ->numeric(),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['order_id'] = $this->getRecord()->id;
        return $data;
    }
}