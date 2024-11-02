<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;

class LatestUsers extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(UserResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label(__('Avatar'))
                    ->circular()
                    ->defaultImageUrl(getCurrentDisk())
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name='.$record->name),
                Tables\Columns\TextColumn::make('username')
                    ->label(__('Username'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('Email verified'))
                    ->badge()
                    ->getStateUsing(fn (User $record): string => $record->email_verified_at?->isPast() ? __('Verified') : __('Not verified'))
                    ->colors([
                        'success' => __('Verified'),
                    ])
                    ->sortable()
                    ->searchable(),
            ]);
    }

    protected function getTableHeading(): string | Htmlable | null
    {
        return __('New users');
    }
}
