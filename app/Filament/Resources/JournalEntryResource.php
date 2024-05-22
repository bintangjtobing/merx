<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalEntryResource\Pages;
use App\Models\JournalEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JournalEntryResource extends Resource
{
    protected static ?string $model = JournalEntry::class;

    protected static ?string $navigationGroup = 'Finance management';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'name')
                    ->required()
                    ->label('Account'),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->label('Date'),
                Forms\Components\TextInput::make('debit')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Debit Amount'),
                Forms\Components\TextInput::make('credit')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Credit Amount'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\Select::make('transaction_id')
                    ->relationship('transaction', 'id')
                    ->label('Transaction ID')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account.name')
                    ->label('Account Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('debit')
                    ->numeric()
                    ->sortable()
                    ->label('Debit Amount'),
                Tables\Columns\TextColumn::make('credit')
                    ->numeric()
                    ->sortable()
                    ->label('Credit Amount'),
                Tables\Columns\TextColumn::make('transaction.type')
                    ->label('Transaction Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
            ])
            ->filters([
                // Define any filters here
            ])
            ->actions([
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
            'index' => Pages\ListJournalEntries::route('/'),
            'create' => Pages\CreateJournalEntry::route('/create'),
            'edit' => Pages\EditJournalEntry::route('/{record}/edit'),
        ];
    }
}