<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                ->required()
                ->maxLength(255),

                TextInput::make('phone_number')
                ->required()
                ->maxLength(255),

                TextInput::make('trx_id')
                ->required()
                ->maxLength(255),

                Textarea::make('address')
                ->required()
                ->maxLength(1024),

                TextInput::make('total_amount')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                TextInput::make('duration')
                ->required()
                ->numeric()
                ->prefix('Days')
                ->maxValue(255),

                Select::make('product_id')
                ->relationship('product', 'name')
                ->searchable()
                ->preload()
                ->required(),

                Select::make('store_id')
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('started_at')
                ->required(),

                DatePicker::make('ended_at')
                ->required(),

                Select::make('delivery_type')
                    ->options([
                        'pickup' => 'Pickup Store',
                        'home_delivery' => 'Home Delivery',
                    ])
                    ->required(),

                FileUpload::make('proof')
                ->required()
                ->openable()
                ->image(),

                Select::make('is_paid')
                ->options([
                    true => 'Paid',
                    false => 'Not Paid',
                ])
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')
                ->searchable(),

                TextColumn::make('trx_id')
                ->searchable(),

                TextColumn::make('total_amount')
                ->numeric()
                ->prefix('Rp '),

                IconColumn::make('is_paid')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Sudah Bayar?'),

                TextColumn::make('product.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
