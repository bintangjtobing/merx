<?php
namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeCategoryResource\Pages;
use App\Filament\Resources\EmployeeCategoryResource\RelationManagers; // Adjust the namespace as needed
use App\Models\EmployeeCategory; // Replace with your actual model
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeCategoryResource extends Resource
{
    protected static ?string $model = EmployeeCategory::class; // Replace with your actual model

    protected static ?string $navigationGroup = 'Company Management';
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description']; // Adjust as needed
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return []; // Consider adding details here if needed
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Employee Category Information')
                    ->description('Details about the employee category')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here if necessary
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make('Employee Category Details')
                    ->description('Additional information about the category')
                    ->schema([
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('description')->label('Description'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relationships here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeCategories::route('/'),
            'create' => Pages\CreateEmployeeCategory::route('/create'),
            // 'view' => Pages\ViewEmployeeCategory::route('/{record}'),
            'edit' => Pages\EditEmployeeCategory::route('/{record}/edit'),
        ];
    }
}