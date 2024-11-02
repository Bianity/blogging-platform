<div x-data>
    <div
        class="mb-5 bg-white hover:shadow-card dark:bg-slate-800 dark:text-slate-200 md:rounded-lg">
        <div class="flex items-center justify-between px-4 pt-3 sm:justify-start md:px-5">
            <div class="flex min-w-[120px] items-center sm:min-w-[0px]">
                <a class="mr-3"
                    href="{{ route('user.show', ['user' => $story->user->username]) }}">
                    <x-users.avatar-circle-card :user="$story->user" />
                </a>
                <div
                    class="mr-3 text-sm font-medium text-gray-900 dark:text-slate-400 md:block">
                    <a
                        href="{{ route('user.show', ['user' => $story->user->username]) }}">
                        {{ $story->user->name ? $story->user->name : $story->user->username }}
                    </a>
                </div>
            </div>
            @if ($story->isCommunities())
                <a href="{{ route('community.show', ['community' => $story->community->slug]) }}"
                    class="mr-3 hidden items-center text-sm font-bold text-gray-900 hover:text-primary-500 dark:text-slate-200 dark:hover:text-primary-500 sm:flex">
                    <div class="w-36 overflow-hidden truncate sm:w-full">
                        {{ $story->community->name }}
                    </div>
                </a>
            @endif
            <time datetime="{{ $story->published_at }}"
                class="text-xs">{{ $story->published_at->diffForHumans() }}</time>
        </div>

        <h2 class="mb-2 mt-3 px-4 text-2xl font-semibold text-gray-900 dark:text-slate-200 md:px-5">
            <a href="{{ route('story.show', $story->slug) }}">
                {{ $story->title }}
            </a>
        </h2>
        <div class="space-y-4 px-4 text-base text-gray-700 dark:text-slate-200 md:px-5">
            {{ $story->summary }}
        </div>

        @if ($story->getFirstMedia('featured-image'))
            <div class="relative mt-2">
                {!! $story->getFirstMedia('featured-image')->img('', ['class' => 'max-h-96 object-cover w-full', 'alt' => $story->title]) !!}
            </div>
        @endif

        <div class="flex items-center justify-between space-x-6 px-4 py-3 md:space-x-8 md:px-5">
            <div class="flex items-center space-x-6">
                <a href="{{ route('story.show', $story) . '#comment' }}"
                    class="item-center group flex text-gray-400 hover:text-gray-500 dark:text-slate-200 dark:hover:text-slate-300">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg group-hover:bg-primary-500/10">
                        <x-icons.comments
                            class="h-5 w-5 text-gray-600 group-hover:text-primary-500 dark:text-slate-200" />
                    </div>
                    @if ($story->comments_count > 0)
                        <span
                            class="text-md ml-1 flex items-center font-medium leading-5 text-gray-900 group-hover:text-primary-500 dark:text-slate-200">{{ $story->comments_count }}</span>
                    @else
                        <span
                            class="text-md ml-1 hidden items-center font-medium leading-5 text-gray-900 group-hover:text-primary-500 dark:text-slate-200 md:flex">{{ __('Discuss') }}</span>
                    @endif
                </a>

                <div
                    class="item-center flex justify-center text-gray-400 hover:text-gray-500 dark:text-slate-200">
                    <x-icons.eye class="mr-[6px] h-5 w-5 text-gray-600 dark:text-slate-200" />
                    <span
                        class="text-md font-medium leading-5 text-gray-900 dark:text-slate-200">{{ views($story)->remember()->count() }}</span>
                </div>
                <x-buttons.share :story="$story" />
                {{-- Save --}}
                @if (auth()->id() !== $story->user->id)
                    <livewire:front.favorite :model="$story" wire:key="{{ $story->id }}" />
                @endif
            </div>
            <div class="flex items-center">
                <livewire:front.vote :model="$story" wire:key="{{ $story->id }}" />
            </div>
        </div>
    </div>
</div>
