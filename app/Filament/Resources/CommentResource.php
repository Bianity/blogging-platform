<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function getNavigationGroup(): ?string
    {
        return __('Main');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Comments');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('comment')
                    ->hiddenLabel(__('Comment'))
                    ->autosize(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.username')
                    ->label(__('Author'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->formatStateUsing(function ($state) {
                        $truncatedValue = Str::limit($state, 60);

                        return new HtmlString("<span title='{$state}'>{$truncatedValue}</span>");
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('story.title')
                    ->label(__('Story'))
                    ->formatStateUsing(function ($state) {
                        $truncatedValue = Str::limit($state, 50);

                        return new HtmlString("<span title='{$state}'>{$truncatedValue}</span>");
                    })
                    ->sortable()
                    ->searchable(),
            ])->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->modalWidth('xl'),
                Tables\Actions\EditAction::make()->modalWidth('xl')->label(false)->size('md')->tooltip(__('Edit')),
                Tables\Actions\DeleteAction::make()->label(false)->size('md')->tooltip(__('Delete')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
