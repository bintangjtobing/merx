<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountsTransactionResource\Pages;
use App\Models\AccountsTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountsTransactionResource extends Resource
{
    protected static ?string $model = AccountsTransaction::class;

    protected static ?string $navigationGroup = 'Finance management';
    protected static ?int $navigationSort = 3;

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

    public static function getRelations(): array
    {
        return [
            // Define any relation managers here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountsTransactions::route('/'),
            'create' => Pages\CreateAccountsTransaction::route('/create'),
            'view' => Pages\ViewAccountsTransaction::route('/{record}'),
            'edit' => Pages\EditAccountsTransaction::route('/{record}/edit'),
        ];
    }
}