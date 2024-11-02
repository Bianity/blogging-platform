<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'username';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
        return __('Main');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('Account'))
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('Name'))
                                    ->maxValue(100),

                                Forms\Components\TextInput::make('username')
                                    ->label(__('Username'))
                                    ->maxValue(60)
                                    ->required(),

                                Forms\Components\TextInput::make('email')
                                    ->label(__('Email address'))
                                    ->required()
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->label(__('Password'))
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('roles')
                                    ->label(__('Select role'))
                                    ->multiple()
                                    ->relationship('roles', 'name')
                                    ->maxItems(1)
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull(),

                            ])
                            ->columns(2)
                            ->collapsible(),
                        Forms\Components\Section::make(__('Cover image'))
                            ->schema([
                                Forms\Components\FileUpload::make('cover_image')
                                    ->image()
                                    ->imageEditor()
                                    ->disk(getCurrentDisk())
                                    ->directory('covers')
                                    ->visibility('public')
                                    ->hiddenLabel(),
                            ])->collapsed(),
                        Forms\Components\Section::make(__('Profile'))
                            ->relationship('profile')
                            ->schema([
                                Forms\Components\Textarea::make('bio')
                                    ->label(__('Bio'))
                                    ->autosize()
                                    ->minLength(5)
                                    ->maxLength(200),
                                Forms\Components\TextInput::make('website')
                                    ->label(__('Website'))
                                    ->prefixIcon('heroicon-m-globe-alt')
                                    ->url()
                                    ->minValue(5)
                                    ->maxValue(100),
                                Forms\Components\TextInput::make('location')
                                    ->label(__('Location'))
                                    ->prefixIcon('heroicon-m-map')
                                    ->minValue(3)
                                    ->maxValue(100),
                                Forms\Components\TextInput::make('company')
                                    ->label(__('Company'))
                                    ->prefixIcon('heroicon-m-briefcase')
                                    ->minValue(3)
                                    ->maxValue(100),
                                Forms\Components\TextInput::make('education')
                                    ->label(__('Education'))
                                    ->prefixIcon('heroicon-m-academic-cap')
                                    ->minValue(10)
                                    ->maxValue(100),
                                Forms\Components\TextInput::make('facebook')
                                    ->label(__('Facebook'))
                                    ->prefixIcon('heroicon-m-globe-alt')
                                    ->url()
                                    ->minValue(6)
                                    ->maxValue(200),
                                Forms\Components\TextInput::make('twitter')
                                    ->label(__('Twitter'))
                                    ->prefixIcon('heroicon-m-globe-alt')
                                    ->url()
                                    ->minValue(6)
                                    ->maxValue(200),
                                Forms\Components\TextInput::make('instagram')
                                    ->label(__('Instagram'))
                                    ->prefixIcon('heroicon-m-globe-alt')
                                    ->url()
                                    ->minValue(6)
                                    ->maxValue(200),
                                Forms\Components\TextInput::make('tiktok')
                                    ->label(__('Tiktok'))
                                    ->prefixIcon('heroicon-m-globe-alt')
                                    ->url()
                                    ->minValue(6)
                                    ->maxValue(200),
                                Forms\Components\TextInput::make('youtube')
                                    ->label(__('Youtube'))
                                    ->prefixIcon('heroicon-m-globe-alt')
                                    ->url()
                                    ->minValue(6)
                                    ->maxValue(200),
                            ])->collapsed(),
                    ])->columnSpan(['lg' => fn (?User $record) => $record === null ? 2 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->label(__('Avatar'))
                            ->image()
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->disk(getCurrentDisk())
                            ->directory('avatars')
                            ->visibility('public'),

                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('Created'))
                            ->content(fn (User $record): ?string => $record->created_at?->diffForHumans())
                            ->hidden(fn (?User $record) => $record === null),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('Last modified'))
                            ->content(fn (User $record): ?string => $record->updated_at?->diffForHumans())
                            ->hidden(fn (?User $record) => $record === null),

                        Forms\Components\Placeholder::make('last_seen')
                            ->label(__('Last online'))
                            ->content(fn (User $record): ?string => $record->last_seen?->diffForHumans())
                            ->hidden(fn (?User $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->circular()
                    ->defaultImageUrl(getCurrentDisk())
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name='.$record->name),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->label(__('Username'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('Role'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user' => 'gray',
                        'author' => 'gray',
                        'editor' => 'gray',
                        'moderator' => 'warning',
                        'administrator' => 'success',
                        'readonly' => 'danger',
                    })
                    ->sortable(),
                ToggleIconColumn::make('is_banned')
                    ->label(__('Banned'))
                    ->translateLabel()
                    ->alignCenter()
                    ->disabled(fn (User $user): bool => $user->isAdmin() ? true : false)
                    ->onIcon('heroicon-s-exclamation-circle')
                    ->offIcon('heroicon-o-exclamation-circle')
                    ->tooltip(fn (User $record) => $record->is_banned ? __('Unban') : __('Ban'))
                    ->sortable(),
            ])->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(false)->size('md')->tooltip(__('Edit')),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\StoriesRelationManager::class,
            RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['stories', 'comments'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
