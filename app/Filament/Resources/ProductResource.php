<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\PhotosRelationManager;
use App\Models\Brand;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Managemen Product';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                ->required()
                ->maxLength(255),

                Textarea::make('about')
                ->required()
                ->maxLength(1024),

                TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                FileUpload::make('thumbnail')
                ->required()
                ->image(),

                Select::make('category_id')
                ->required()
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set){
                    $set('brand_id', null);
                }),

                Select::make('brand_id')
                ->options(function (callable $get) {
                    $categoryId = $get('category_id');
                    if ($categoryId) {
                        return Brand::whereHas('brandCategories', function ($query) use ($categoryId) {
                            $query->where('category_id', $categoryId);
                        })->pluck('name', 'id');
                    }
                    return [];
                })
                ->searchable()
                ->preload()
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

                ImageColumn::make('thumbnail'),

                TextColumn::make('category.name'),

                TextColumn::make('brand.name'),
            ])
            ->filters([
                //
                SelectFilter::make('category_id')
                ->label('Category')
                    ->relationship('category', 'name'),

                SelectFilter::make('brand_id')
                ->label('Brand')
                    ->relationship('brand', 'name'),
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
            PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
