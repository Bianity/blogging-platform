<div class="w-content">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a class="mr-3"
                href="{{ route('user.show', ['user' => $story->user->username]) }}">
                <x-users.avatar-circle :user="$story->user" />
            </a>
            <div class="flex flex-col">
                <div class="text-sm font-medium text-gray-900 dark:text-slate-400 md:block">
                    <a href="{{ route('user.show', ['user' => $story->user->username]) }}">
                        {{ $story->user->name ? $story->user->name : $story->user->username }}
                    </a>
                </div>
                <div class="flex">
                    <time class="text-xs text-gray-400"
                        datetime="{{ $story->published_at }}">{{ $story->ReadableDate }}
                    </time>
                    @if ($story->readTimeCount() != 0)
                        <div class="px-2 text-xs text-gray-400">&bull;</div>
                        <span class="text-xs text-gray-400">{{ $story->readTime() }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div x-data="{ isOpen: false }"
            class="flex items-center space-x-2 md:mt-0">
            @auth
                <div class="relative">
                    <button @click="isOpen = !isOpen"
                        class="relative h-6 rounded-full px-2">
                        <x-icons.three-dots-horizontal />
                    </button>
                    <ul
                        wire:ignore
                        x-cloak x-show="isOpen" x-transition.duration.300ms
                        class="absolute right-0 top-8 z-10 w-44 rounded-xl bg-white p-1 text-sm font-medium shadow-dialog dark:bg-slate-900 dark:text-slate-200 md:top-6">
                        @if (auth()->id() !== $story->user->id)
                            <li wire:ignore>
                                <livewire:front.report-story :story="$story" wire:key="report-story" />
                            </li>
                        @endif
                        @can('update', $story)
                            <li>
                                <a href="{{ route('story.edit', ['story' => $story->id]) }}"
                                    class="hover:shadow-xs block rounded px-5 py-2 transition duration-100 ease-in hover:bg-slate-100 dark:hover:bg-slate-700">{{ __('Edit') }}</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            @endauth
        </div>
    </div>

    <h1 class="my-5 break-words text-2xl font-semibold dark:text-white sm:text-title2">
        {{ $story->title }}
    </h1>

    @if (isset($story->subtitle))
        <h2 class="my-5 break-words text-lg font-medium dark:text-gray-200 sm:text-title">
            {{ $story->subtitle }}</h2>
    @endif
</div>
