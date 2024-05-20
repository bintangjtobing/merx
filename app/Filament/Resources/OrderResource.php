<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Transaction Order';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_ref')->maxLength(255),
                Forms\Components\Select::make('vendor_id')
    ->relationship('vendor', 'name') // Sesuaikan dengan nama relasi pada model Order
    ->required(),

Forms\Components\Select::make('warehouse_id')
    ->relationship('warehouse', 'name') // Sesuaikan dengan nama relasi pada model Order
    ->required(),

                Forms\Components\TextInput::make('status')->required(),
                Forms\Components\Textarea::make('details')->columnSpanFull(),
                Forms\Components\TextInput::make('unit_of_measure')->required()->maxLength(255)->default('pcs'),
                Forms\Components\TextInput::make('taxes')->numeric(),
                Forms\Components\TextInput::make('shipping_cost')->numeric(),
                Forms\Components\Repeater::make('products')
                ->schema([
                    Forms\Components\Select::make('product_id')
                        ->relationship('products', 'name')
                        ->required(),
                    Forms\Components\TextInput::make('quantity')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $pricePerUnit = $get('price_per_unit') ?: 0;
                            $set('total_price', $state * $pricePerUnit);
                        }),
                    Forms\Components\TextInput::make('price_per_unit')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $quantity = $get('quantity') ?: 0;
                            $set('total_price', $state * $quantity);
                        }),
                    Forms\Components\TextInput::make('total_price')
                        ->numeric()
                        ->required()
                        ->disabled()
                        ->dehydrated(false),
                ])
                ->columns(4)
                ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_ref')->searchable(),
                Tables\Columns\TextColumn::make('vendor_id')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('warehouse_id')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('unit_of_measure')->searchable(),
                Tables\Columns\TextColumn::make('taxes')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('shipping_cost')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('total_price')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}