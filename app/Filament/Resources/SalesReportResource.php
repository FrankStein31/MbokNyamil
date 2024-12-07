<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesReportResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers;

class SalesReportResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Sales Report';
    protected static ?string $modelLabel = 'Sales Report';
    protected static ?string $pluralModelLabel = 'Sales Reports';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Transaction Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('items')
                    ->label('Products')
                    ->state(function (Order $record) {
                        return $record->items->map(function ($item) {
                            return "{$item->product->name} (Qty: {$item->quantity})";
                        })->implode("\n");
                    })
                    ->wrap(),

                Tables\Columns\TextColumn::make('total_items')
                    ->label('Total Items')
                    ->state(function (Order $record) {
                        return $record->items->sum('quantity');
                    }),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Sales')
                    ->money('IDR')
                    ->summarize(
                        Summarizers\Sum::make()->formatStateUsing(function ($state) {
                            return "IDR " . number_format($state, 2, ',', '.');
                        })
                    ),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'success',
                        'finished' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from_date')->label('From'),
                        DatePicker::make('to_date')->label('To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['to_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    })
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalesReports::route('/'),
        ];
    }
}
