<div
    class="relative mx-auto flex w-full pt-6 md:grid md:grid-cols-main-md md:gap-2 md:px-2 lg:max-w-7xl lg:grid-cols-main lg:gap-4">
    <x-menu.main />
    <div class="block w-full max-w-3xl">
        {{-- Navigation Saved --}}
        <x-menu.saved />
        {{-- Saved Comments --}}
        @foreach ($savedComments as $comment)
            <div
                class="mb-5 bg-white py-6 hover:shadow-card dark:bg-slate-800 dark:text-slate-200 md:rounded-lg">
                <div class="flex items-center space-x-3 px-5">
                    <div class="flex items-center">
                        <a class="mr-3"
                            href="{{ route('user.show', ['user' => $comment->user->username]) }}">
                            <x-users.avatar-circle-card :user="$comment->user" />
                        </a>
                        <div
                            class="text-sm font-medium text-gray-900 dark:text-slate-400 md:block">
                            <a
                                href="{{ route('user.show', ['user' => $comment->user->username]) }}">
                                {{ $comment->user->name ? $comment->user->name : $comment->user->username }}
                            </a>
                        </div>
                    </div>
                    <time datetime="{{ $comment->created_at }}"
                        class="text-xs">{{ $comment->created_at->diffForHumans() }}</time>
                </div>

                <div class="mt-3 px-5 text-base text-gray-700 dark:text-slate-200">
                    {!! $comment->comment !!}
                </div>

                <div class="mt-2 flex items-center justify-between px-5">
                    {{-- Save --}}
                    @if (auth()->id() !== $comment->user->id)
                        <livewire:front.favorite :model="$comment" wire:key="saved-comment-{{ $comment->id }}" />
                    @endif

                    <div class="flex items-center">
                        <livewire:front.vote :model="$comment" wire:key="vote-comment-{{ $comment->id }}" />
                    </div>
                </div>
            </div>
        @endforeach
        @if ($totalRecords != 0)
            @if ($savedComments->hasMorePages())
                <x-ui.skeleton />
                <div x-intersect="$wire.loadMore" class="grid grid-cols-1"></div>
            @endif
        @else
            <div
                class="flex w-full items-center justify-center rounded-md bg-white p-20 dark:bg-slate-800">
                <div class="flex flex-col items-center gap-3">
                    <x-icons.clock class="h-20 w-20 text-slate-400" />
                    <p class="text-center text-lg font-medium text-slate-500 dark:text-slate-400">
                        {{ __('You don\'t have any saved comments') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
    <aside class="hidden space-y-4 lg:block">
        @if (App\Models\Story::published()->count() != 0)
            <x-widgets.top-authors />
            <x-widgets.popular-tags />
        @endif
        <div class="sticky top-20">
            @if ($advancedSettings->banner_sidebar_widget !== '')
                <section>{!! $advancedSettings->banner_sidebar_widget !!}</section>
            @endif
            <div class="mt-5">
                <x-menu.footer />
            </div>
        </div>
    </aside>
</div>
