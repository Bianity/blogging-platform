<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Story;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsApp extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected static bool $isLazy = true;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('Total users'), User::query()->count())
                ->icon('heroicon-o-users')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => 'gotoUsers()',
                ]),
            Stat::make(__('Total stories'), Story::query()->count())
                ->icon('heroicon-o-rectangle-stack')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => 'gotoStories()',
                ]),
            Stat::make(__('Total comments'), Comment::query()->count())
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => 'gotoComments()',
                ]),
            Stat::make(__('Total communities'), Community::count())
                ->icon('heroicon-o-user-group')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => 'gotoCommunities()',
                ]),
        ];
    }

    public function gotoUsers()
    {
        return to_route('filament.cp.resources.users.index');
    }

    public function gotoStories()
    {
        return to_route('filament.cp.resources.stories.index');
    }

    public function gotoComments()
    {
        return to_route('filament.cp.resources.comments.index');
    }

    public function gotoCommunities()
    {
        return to_route('filament.cp.resources.communities.index');
    }
}
