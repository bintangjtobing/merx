<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountsTransactionResource\Pages;
use App\Models\AccountsTransaction;
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

class AccountsTransactionResource extends Resource
{
    protected static ?string $model = AccountsTransaction::class;

    protected static ?string $navigationGroup = 'Finance management';
    protected static ?int $navigationSort = 3;

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->account->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['account.name', 'type', 'date'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Account' => $record->account->name,
            'Transaction Type' => $record->type,
            'Amount' => number_format($record->amount, 2, '.', ''),
            'Description' => $record->description,
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'debit' => 'Debit',
                        'credit' => 'Credit',
                    ])
                    ->required()
                    ->label('Transaction Type'),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->label('Date'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Amount'),
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'name')
                    ->required()
                    ->label('Account'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Transaction Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->label('Amount'),
                Tables\Columns\TextColumn::make('account.name')
                    ->label('Account Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable(),
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
                Section::make('Account Transaction Details')
                    ->description('Information about the account transaction')
                    ->schema([
                        TextEntry::make('type')->label('Transaction Type'),
                        TextEntry::make('date')->label('Date'),
                        TextEntry::make('amount')->label('Amount'),
                        TextEntry::make('account.name')->label('Account'),
                        TextEntry::make('description')->label('Description'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return []; // Empty array
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountsTransactions::route('/'),
            'create' => Pages\CreateAccountsTransaction::route('/create'),
            // 'view' => Pages\ViewAccountsTransaction::route('/{record}'),
            'edit' => Pages\EditAccountsTransaction::route('/{record}/edit'),
        ];
    }
}