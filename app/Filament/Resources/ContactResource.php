<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    public static function getNavigationGroup(): ?string
    {
        return __('Main');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Contacts');
    }

    public static function getNavigationBadge(): ?string
    {
        return (static::getModel()::where('is_viewed', false)->count() > 0) ? static::getModel()::where('is_viewed', false)->count() : false;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('is_viewed', false)->count() > 10 ? 'danger' : 'warning';
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
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->date(),
                ToggleIconColumn::make('is_viewed')
                    ->label(__('Status'))
                    ->translateLabel()
                    ->alignCenter()
                    ->onIcon('heroicon-o-eye')
                    ->offIcon('heroicon-o-eye')
                    ->tooltip(fn (Contact $record) => $record->is_viewed != 1 ? __('Not viewed') : __('Viewed'))
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
                                Components\TextEntry::make('name')
                                    ->label(__('Name')),
                                Components\TextEntry::make('email')
                                    ->label(__('Email')),
                                Components\TextEntry::make('created_at')
                                    ->label(__('Date'))
                                    ->badge()
                                    ->date()
                                    ->color('success'),
                            ]),
                        Components\TextEntry::make('subject')
                            ->label(__('Subject')),

                    ]),
                Components\Section::make(__('Message'))
                    ->schema([
                        Components\TextEntry::make('message')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
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
            'index' => Pages\ListContacts::route('/'),
            'view' => Pages\ViewContacts::route('/{record}'),
        ];
    }
}
