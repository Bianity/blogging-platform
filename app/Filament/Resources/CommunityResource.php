<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityResource\Pages;
use App\Models\Community;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CommunityResource extends Resource
{
    protected static ?string $model = Community::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationGroup(): ?string
    {
        return __('Main');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Communities');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('Name'))
                                    ->required()
                                    ->maxValue(50)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->label(__('Slug'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->unique(Community::class, 'slug', ignoreRecord: true),
                            ]),

                        Forms\Components\Toggle::make('active')
                            ->label(__('Active'))
                            ->default(true),

                        Forms\Components\RichEditor::make('description')
                            ->label(__('Description'))
                            ->required()
                            ->disableToolbarButtons([
                                'attachFiles',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->maxLength(255)
                            ->columnSpan('full'),

                        Forms\Components\RichEditor::make('rules')
                            ->label(__('Rules'))
                            ->disableToolbarButtons([
                                'attachFiles',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->maxLength(1000)
                            ->columnSpan('full'),

                        Forms\Components\FileUpload::make('cover_image')
                            ->label(__('Cover image'))
                            ->image()
                            ->imageEditor()
                            ->disk(getCurrentDisk())
                            ->directory('covers')
                            ->visibility('public'),
                    ])
                    ->columnSpan(['lg' => fn (?Community $record) => $record === null ? 2 : 2]),

                Forms\Components\Section::make(__('Avatar'))
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->label(__('Avatar'))
                            ->image()
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->disk(getCurrentDisk())
                            ->directory('avatars')
                            ->visibility('public')
                            ->hiddenLabel(),
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('Created'))
                            ->content(fn (Community $record): ?string => $record->created_at?->diffForHumans())
                            ->hidden(fn (?Community $record) => $record === null),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('Last modified'))
                            ->content(fn (Community $record): ?string => $record->updated_at?->diffForHumans())
                            ->hidden(fn (?Community $record) => $record === null),

                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label(__('Avatar'))
                    ->circular()
                    ->defaultImageUrl(getCurrentDisk())
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name='.$record->name),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->formatStateUsing(function ($state) {
                        $truncatedValue = Str::limit($state, 100);

                        return new HtmlString("<span title='{$state}'>{$truncatedValue}</span>");
                    }),
                ViewColumn::make('link')
                    ->label(__('URL'))
                    ->view('filament.tables.columns.community-link'),
            ])->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(false)->size('md')->tooltip(__('Edit')),
                Tables\Actions\DeleteAction::make()->label(false)->size('md')->tooltip(__('Delete')),
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
            'index' => Pages\ListCommunities::route('/'),
            'create' => Pages\CreateCommunity::route('/create'),
            'edit' => Pages\EditCommunity::route('/{record}/edit'),
        ];
    }
}
