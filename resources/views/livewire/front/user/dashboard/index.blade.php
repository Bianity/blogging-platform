<div class="relative mx-auto w-full sm:pt-6 md:max-w-7xl">
    <h1 class="mb-5 px-3 text-4xl font-semibold dark:text-slate-200">{{ __('Dashboard') }}</h1>
    <div
        class="md:grid md:grid-cols-12 md:gap-2 lg:gap-4">
        <div class="col-span-3">
            <x-menu.dashboard :user="auth()->user()" />
        </div>
        <div class="col-span-9 mt-5 sm:mt-0">
            <div class="rounded-lg bg-white dark:bg-slate-800">
                <div class="px-3 pt-4">
                    <x-forms.input
                        fullWidth
                        wire:model.live.debounce.500ms="search"
                        id="searchStory"
                        name="searchStory"
                        type="text"
                        value=""
                        placeholder="{{ __('Find your story') }}" />
                </div>

                @if ($stories->count())
                    <div
                        class="my-6 flex justify-between gap-x-2 px-3 pb-2 text-sm dark:border-stone-700">
                        <x-select
                            clearable="0"
                            searchable="0"
                            :options="[10, 15, 25]"
                            wire:model="perPage" />
                        <x-select
                            wire:model.live="sort"
                            clearable="0"
                            searchable="0">
                            <x-select.option label="{{ __('Recently Created') }}" value="created_at|desc" />
                            <x-select.option label="{{ __('Recently Updated') }}" value="updated_at|desc" />
                            <x-select.option label="{{ __('Title A-Z') }}" value="title|asc" />
                            <x-select.option label="{{ __('Title Z-A') }}" value="title|desc" />
                        </x-select>
                    </div>

                    <div
                        class="flex flex-col overflow-x-auto border-b border-t border-gray-200 dark:border-slate-700">
                        <table class="min-w-full text-gray-600 dark:text-slate-200">
                            <thead>
                                <tr>
                                    <th
                                        class="max-w-sm border-b border-gray-200 px-6 py-3 text-left text-xs font-medium uppercase leading-4 tracking-wider dark:border-primary-500">
                                        {{ __('Title') }}</th>
                                    <th
                                        class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium uppercase leading-4 tracking-wider dark:border-primary-500">
                                        {{ __('Status') }}</th>
                                    <th
                                        class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium uppercase leading-4 tracking-wider dark:border-primary-500">
                                        {{ __('Views') }}</th>
                                    <th
                                        class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium uppercase leading-4 tracking-wider dark:border-primary-500">
                                        {{ __('Created') }}</th>
                                    <th
                                        class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium uppercase leading-4 tracking-wider dark:border-primary-500">
                                        {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stories as $story)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                        <td
                                            class="whitespace-no-wrap max-w-sm overflow-hidden truncate px-6 py-4 text-sm font-medium leading-5">
                                            <a
                                                class="hover:text-primary-600"
                                                href="{{ route('story.show', ['story' => $story->slug]) }}">{{ $story->title }}</a>
                                        </td>
                                        <td
                                            class="whitespace-no-wrap px-6 py-4 text-sm leading-5">
                                            @if ($story->isPublished())
                                                <span
                                                    class="inline-flex rounded-full bg-emerald-200 px-2 text-xs font-semibold leading-5 text-gray-800">{{ __('Published') }}</span>
                                            @else
                                                <span
                                                    class="inline-flex rounded-full bg-yellow-200 px-2 text-xs font-semibold leading-5 text-gray-800">{{ __('Draft') }}</span>
                                            @endif

                                        </td>
                                        <td
                                            class="whitespace-no-wrap px-6 py-4 text-sm leading-5">
                                            {{ views($story)->count() }}
                                        </td>
                                        <td
                                            class="whitespace-no-wrap px-6 py-4 text-sm leading-5">
                                            {{ $story->created_at }}</td>
                                        <td
                                            class="whitespace-no-wrap flex items-center space-x-2 px-6 py-4 text-sm leading-5">
                                            @can('update', $story)
                                                <a href="{{ route('story.edit', ['story' => $story->id]) }}"
                                                    class="rounded-lg bg-transparent px-3 py-1.5 font-medium hover:bg-gray-100 hover:text-gray-600 focus:outline-none">{{ __('Edit') }}</a>
                                            @endcan
                                            <x-dropdown>
                                                @can('pin', $story)
                                                    @if ($story->userPinnedStories()->count() < 5)
                                                        @if ($story->is_pinned === 0)
                                                            <button
                                                                class="hover:shadow-xs block w-full rounded px-5 py-2 text-left transition duration-100 ease-in hover:bg-slate-100 dark:hover:bg-slate-700"
                                                                x-on:confirm="{
                                                                        title: '{{ __('Pin the story?') }}',
                                                                        description: '{{ __('Add this story to my pinned collection?') }}',
                                                                        icon: 'question',
                                                                        iconColor: 'text-info-500',
                                                                        iconBackground: 'bg-transparent',
                                                                        accept: {
                                                                        label: '{{ __('Add') }}',
                                                                        method: 'isPinned',
                                                                        params: {{ $story->id }}
                                                                        },
                                                                        params: 1
                                                                        }">
                                                                {{ __('Pin the story') }}
                                                            </button>
                                                        @else
                                                            <button
                                                                title="{{ __('Remove from pinned collection?') }}"
                                                                class="hover:shadow-xs block w-full rounded px-5 py-2 text-left transition duration-100 ease-in hover:bg-slate-100 dark:hover:bg-slate-700"
                                                                x-on:confirm="{
                                                                        title: '{{ __('Remove from pinned collection?') }}',
                                                                        description: '{{ __('This action will remove the story from your pinned collection?') }}',
                                                                        icon: 'question',
                                                                        iconColor: 'text-info-500',
                                                                        iconBackground: 'bg-transparent',
                                                                        accept: {
                                                                        label: '{{ __('Remove') }}',
                                                                        method: 'isPinned',
                                                                        params: {{ $story->id }}
                                                                        },
                                                                        params: 1
                                                                        }">
                                                                {{ __('Unpin story') }}
                                                            </button>
                                                        @endif
                                                    @else
                                                        @if ($story->is_pinned !== 0)
                                                            <button
                                                                title="{{ __('Remove from pinned collection?') }}"
                                                                class="hover:shadow-xs block w-full rounded px-5 py-2 text-left transition duration-100 ease-in hover:bg-slate-100 dark:hover:bg-slate-700"
                                                                x-on:confirm="{
                                                                        title: '{{ __('Remove from pinned collection?') }}',
                                                                        description: '{{ __('This action will remove the story from your pinned collection?') }}',
                                                                        icon: 'question',
                                                                        iconColor: 'text-info-500',
                                                                        iconBackground: 'bg-transparent',
                                                                        accept: {
                                                                        label: '{{ __('Remove') }}',
                                                                        method: 'isPinned',
                                                                        params: {{ $story->id }}
                                                                        },
                                                                        params: 1
                                                                        }">
                                                                {{ __('Unpin story') }}
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endcan

                                                @can('delete', $story)
                                                    <button type="button"
                                                        class="block w-full rounded-lg bg-transparent px-5 py-2 text-left font-medium text-red-600 hover:bg-red-50 focus:outline-none dark:text-red-300 dark:hover:bg-red-800 dark:hover:bg-opacity-40 dark:hover:text-white"
                                                        x-on:confirm="{
                                                                    title: '{{ __('Delete Story?') }}',
                                                                    description: '{{ __('Are you sure you want to delete this story? You cannot undo this action!') }}',
                                                                    icon: 'error',
                                                                    iconColor: 'text-red-500',
                                                                    iconBackground: 'bg-transparent',
                                                                    accept: {
                                                                        label: '{{ __('Delete') }}',
                                                                        method: 'deleteStory',
                                                                        params: {{ $story->id }}
                                                                    },
                                                                    params: 1
                                                            }">{{ __('Delete') }}
                                                    </button>
                                                @endcan
                                            </x-dropdown>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-3 py-4">
                        {{ $stories->links() }}
                    </div>
                @else
                    <h2
                        class="py-8 text-center text-xl tracking-wide text-gray-600 dark:text-slate-200">
                        {{ __('No results match that query') }}</h2>
                @endif
            </div>
        </div>
    </div>
</div>
