<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Filament\Resources\WarehousesResource\RelationManagers\ProductsRelationManager;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;


    protected static ?string $navigationGroup = 'System management';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'name';
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['name','code','type','subtype','warehouse.name'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Warehouse' => $record->warehouse->name,
            'Product Code' => $record->code,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Product Name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->nullable(),
                Forms\Components\TextInput::make('image_product')
                    ->label('Image URL')
                    ->default('https://res.cloudinary.com/boxity-id/image/upload/v1709745192/39b09e1f-0446-4f78-bbf1-6d52d4e7e4df.png')
                    ->nullable(),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('type')
                    ->label('Type')
                    ->nullable(),
                Forms\Components\TextInput::make('subtype')
                    ->label('Subtype')
                    ->nullable(),
                Forms\Components\TextInput::make('size')
                    ->label('Size')
                    ->nullable(),
                Forms\Components\TextInput::make('color')
                    ->label('Color')
                    ->nullable(),
                Forms\Components\TextInput::make('brand')
                    ->label('Brand')
                    ->nullable(),
                Forms\Components\TextInput::make('model')
                    ->label('Model')
                    ->nullable(),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->nullable(),
                Forms\Components\TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->nullable(),
                Forms\Components\TextInput::make('video')
                    ->label('Video')
                    ->nullable(),
                Forms\Components\Toggle::make('raw_material')
                    ->label('Raw Material')
                    ->default(false),
                Forms\Components\TextInput::make('unit_of_measure')
                    ->label('Unit of Measure')
                    ->nullable(),
                Forms\Components\Select::make('warehouse_id')
                    ->label('Warehouse')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->nullable(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Product Code')
                    ->sortable()
                    ->searchable(isIndividual:true, isGlobal:true),
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->sortable()
                    ->description(fn (Products $record): string => $record->description)
                    ->searchable(isIndividual:true, isGlobal:true),
                    Tables\Columns\TextColumn::make('warehouse.name')
                        ->label('Warehouse')
                        ->badge()
                        ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtype')
                    ->label('Subtype')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                    ->success()
                    ->title('Product Deleted.')
                    ->body('The product has been successfully deleted.')
                )
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function infolist(Infolist $infolist): InfoList
    {
        return $infolist
            ->schema([
                Section::make('Product Info')
                    ->description('Information about the product')
                    ->schema([
                        TextEntry::make('name')->label('Product Name'),
                        TextEntry::make('code')->label('Product Code'),
                        TextEntry::make('description')->label('Description'),
        TextEntry::make('price')->label('Price'),
                        TextEntry::make('type')->label('Type'),
                        TextEntry::make('subtype')->label('Subtype'),
                        TextEntry::make('size')->label('Size'),
                        TextEntry::make('color')->label('Color'),
                        TextEntry::make('brand')->label('Brand'),
        TextEntry::make('stock')->label('Stock'),
                        TextEntry::make('unit_of_measure')->label('Unit of Measure'),
                        TextEntry::make('warehouse.name')->label('Warehouse'),
                    ])->columns(3)
            ]);
    }
    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            // 'view' => Pages\ViewProducts::route('/{record}'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}