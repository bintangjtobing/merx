<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehousesResource\Pages;
use App\Filament\Resources\WarehousesResource\RelationManagers\ProductsRelationManager;
use App\Models\Warehouses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;

class WarehousesResource extends Resource
{
    protected static ?string $model = Warehouses::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-library';
    protected static ?string $navigationGroup = 'System management';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['name','address'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Address' => $record->address,
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
                    ->label('Warehouse Name')
                    ->required(),
                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->required(),
                Forms\Components\TextInput::make('capacity')
                    ->label('Capacity')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Warehouse Name')
                    ->description(fn (Warehouses $record): string => $record->address)
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->label('Capacity')
                    ->numeric(decimalPlaces: 0)
                    ->sortable(),
            ])
            ->filters([
                // Add filters here if necessary
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Warehouse Info')
                    ->description('Information about the warehouse')
                    ->schema([
                        TextEntry::make('name')->label('Warehouse Name'),
                        TextEntry::make('address')->label('Address'),
                        TextEntry::make('capacity')->label('Capacity'),
                    ])->columns(2)
            ]);
    }


    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouses::route('/create'),
            // 'view' => Pages\ViewWarehouses::route('/{record}'),
            'edit' => Pages\EditWarehouses::route('/{record}/edit'),
        ];
    }
}