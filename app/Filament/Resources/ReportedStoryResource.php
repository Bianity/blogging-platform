<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportedStoryResource\Pages;
use App\Models\ReportedStory;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReportedStoryResource extends Resource
{
    protected static ?string $model = ReportedStory::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    public static function getNavigationGroup(): ?string
    {
        return __('Reports');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Stories');
    }

    public static function getNavigationBadge(): ?string
    {
        return (static::getModel()::where('is_viewed', '!=', true)->count() > 0) ? static::getModel()::where('is_viewed', '!=', true)->count() : false;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('is_viewed', '!=', true)->count() > 10 ? 'danger' : 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.username')
                    ->label(__('Report by'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('story.title')
                    ->label(__('Story title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label(__('Reason'))
                    ->sortable()
                    ->searchable(),
                ToggleIconColumn::make('is_viewed')
                    ->label(__('Status'))
                    ->translateLabel()
                    ->alignCenter()
                    ->onIcon('heroicon-o-eye')
                    ->offIcon('heroicon-o-eye')
                    ->tooltip(fn (ReportedStory $record) => $record->is_viewed != 1 ? __('Not viewed') : __('Viewed'))
                    ->sortable(),
            ])->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
                Components\Section::make()
                    ->schema([
                        Components\Grid::make(3)
                            ->schema([
                                Components\TextEntry::make('user.username')
                                    ->label(__('Report by')),
                                Components\TextEntry::make('reason')
                                    ->label(__('Reason')),
                                Components\TextEntry::make('created_at')
                                    ->label(__('Date'))
                                    ->badge()
                                    ->date(),
                            ]),
                        Components\TextEntry::make('story.title')
                            ->label(__('Story')),

                    ]),
                Components\Section::make(__('Message'))
                    ->schema([
                        Components\TextEntry::make('message')
                            ->prose()
                            ->hiddenLabel(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportedStories::route('/'),
        ];
    }
}
