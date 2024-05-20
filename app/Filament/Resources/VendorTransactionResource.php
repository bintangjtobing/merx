<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorTransactionResource\Pages;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VendorTransactionResource extends Resource
{
    protected static ?string $model = VendorTransaction::class;

    protected static ?string $navigationGroup = 'Customer & Supplier';
    protected static ?int $navigationSort = 2;

    public static function form(Forms\Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vendors_id')
                ->label('Vendor')
                ->relationship('vendors', 'name')
                ->searchable()
                ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Amount'),
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('unit_price')
                    ->numeric()
                    ->label('Unit Price'),
                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->label('Total Price'),
                Forms\Components\TextInput::make('taxes')
                    ->numeric()
                    ->label('Taxes'),
                Forms\Components\TextInput::make('shipping_cost')
                    ->numeric()
                    ->label('Shipping Cost'),
            ]);
    }

    public static function table(Tables\Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('taxes')
                    ->label('Taxes')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_cost')
                    ->label('Shipping Cost')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created At')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Updated At')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Define any filters here
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relation managers here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendorTransactions::route('/'),
            'create' => Pages\CreateVendorTransaction::route('/create'),
            'view' => Pages\ViewVendorTransaction::route('/{record}'),
            'edit' => Pages\EditVendorTransaction::route('/{record}/edit'),
        ];
    }
}