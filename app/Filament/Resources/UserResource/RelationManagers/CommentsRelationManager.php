<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected function getTableHeading(): string | Htmlable | null
    {
        return __('Comments');
    }

    public static function getPluralRecordLabel(): string
    {
        return __('comments');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->formatStateUsing(function ($state) {
                        $truncatedValue = Str::limit($state, 100);

                        return new HtmlString("<span title='{$state}'>{$truncatedValue}</span>");
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DetachBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                TextEntry::make('user.username')
                    ->label(__('Author')),
                TextEntry::make('story.title')
                    ->label(__('Story')),
                TextEntry::make('comment')
                    ->label(__('Comment'))
                    ->html(),
                TextEntry::make('created_at')
                    ->label(__('Created'))
                    ->badge(),
            ]);
    }
}
