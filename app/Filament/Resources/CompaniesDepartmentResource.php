<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompaniesDepartmentResource\Pages;
use App\Filament\Resources\CompaniesDepartmentResource\RelationManagers;
use App\Models\CompaniesDepartment;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;

class CompaniesDepartmentResource extends Resource
{
    protected static ?string $model = CompaniesDepartment::class;

    protected static ?string $navigationGroup = 'Company Management';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name']; // Add other searchable attributes here (e.g., company.name)
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Company' => $record->company->name ?? '-', // Use relationship to access company name
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
                    ->label('Department Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('responsibilities')
                    ->label('Responsibilities')
                    ->maxLength(255),
                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Department Name')
                    ->description(fn (CompaniesDepartment $record) => $record->company->name ?? '-') // Use relationship to access company name
                    ->searchable(),
                Tables\Columns\TextColumn::make('responsibilities')
                    ->label('Responsibilities')
                    ->searchable(),
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
                Section::make('Department Info')
                    ->description('Information about the department')
                    ->schema([
                        TextEntry::make('name')->label('Department Name'),
                        TextEntry::make('company.name')->label('Company'), // Access company name through relationship
                        TextEntry::make('responsibilities')->label('Responsibilities'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships here (e.g., EmployeesRelation::class)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompaniesDepartments::route('/'),
            'create' => Pages\CreateCompaniesDepartment::route('/create'),
            // 'view' => Pages\ViewCompaniesDepartment::route('/{record}'), // Uncomment the view page if needed
            'edit' => Pages\EditCompaniesDepartment::route('/{record}/edit'),
        ];
    }
}
