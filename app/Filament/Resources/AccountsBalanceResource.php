<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountsBalanceResource\Pages;
use App\Filament\Resources\AccountsBalanceResource\RelationManagers;
use App\Models\AccountsBalance;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountsBalanceResource extends Resource
{
    protected static ?string $model = AccountsBalance::class;

    protected static ?string $navigationGroup = 'Finance management';
    protected static ?int $navigationSort = 2;

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->account->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['account.name', 'date'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Account' => $record->account->name,
            'Balance' => number_format($record->balance, 2, '.', ','),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('balance')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('account_id')
                    ->label('Account')
                    ->relationship('account', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label('Account Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
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
                // Define any filters here (e.g. date range filter for 'date')
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
                Section::make('Account Balance Details')
                    ->description('Information about the account balance')
                    ->schema([
                        TextEntry::make('date')->label('Date'),
                        TextEntry::make('account.name')->label('Account'),
                        TextEntry::make('balance')->label('Balance')->disabled()->money('IDR'),
                    ]),
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
            'index' => Pages\ListAccountsBalances::route('/'),
            'create' => Pages\CreateAccountsBalance::route('/create'),
            // 'view' => Pages\ViewAccountsBalance::route('/{record}'),
            'edit' => Pages\EditAccountsBalance::route('/{record}/edit'),
        ];
    }
}
