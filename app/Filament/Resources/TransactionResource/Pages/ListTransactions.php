<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Actions;

use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
{
    return [
        'All' => Tab::make(),
        'Sewa 1 Hari' => Tab::make()
        ->modifyQueryUsing(fn (Builder $query) => $query->where('duration', '=', 1))
        ->badge(Transaction::query()->where('duration', '=', 1)->count()),
        'Sewa 2 Hari' => Tab::make()
        ->modifyQueryUsing(fn (Builder $query) => $query->where('duration', '=', 2))
        ->badge(Transaction::query()->where('duration', '=', 2)->count()),
        'Sewa 3 Hari Lebih' => Tab::make()
        ->modifyQueryUsing(fn (Builder $query) => $query->where('duration', '>=', 3))
        ->badge(Transaction::query()->where('duration', '>=', 3)->count()),
        'Sewa 7 Hari Lebih' => Tab::make()
        ->modifyQueryUsing(fn (Builder $query) => $query->where('duration', '>=', 7))
        ->badge(Transaction::query()->where('duration', '>=', 7)->count()),
    ];
}
}
