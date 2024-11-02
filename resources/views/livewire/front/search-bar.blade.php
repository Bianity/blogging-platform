<div class="relative" x-data="{ isTyped: false }">
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <x-icons.search class="h-4 w-4 text-gray-900 dark:text-slate-400" />
    </div>
    <input name="searchField" type="search"
        wire:model.live.debounce.500ms="query"
        class="dark:highlight-white/5 w-full items-center rounded-lg border-none bg-primary_darker py-2 pl-10 pr-3 text-base font-normal leading-6 placeholder-gray-900 shadow-none transition duration-300 ease-in-out hover:bg-white hover:shadow-md focus:bg-white focus:text-gray-900 focus:placeholder-gray-400 focus:shadow-md focus:outline-none focus:ring-1 focus:ring-primary-500/30 dark:bg-slate-800 dark:text-slate-200 dark:placeholder:text-slate-400 dark:hover:bg-slate-700 dark:focus:ring-0 sm:flex"
        x-ref="searchField"
        x-on:click="isTyped = !isTyped"
        x-on:input.debounce.400ms="isTyped = ($event.target.value != '')"
        x-on:keyup.escape="isTyped = false; $refs.searchField.blur()"
        placeholder='{{ __('Search...') }}'
        autocomplete="off"
        aria-label="{{ __('Search...') }}" />
    @if (strlen($query) > 2)
        <ul class="soft-scrollbar absolute z-50 mt-3 max-h-64 w-full overflow-y-auto rounded-lg bg-white shadow-popup dark:bg-slate-800"
            x-show="isTyped" @click.outside="isTyped = false" x-transition>
            @forelse ($results as $result)
                <li class="border-b border-slate-100 transition duration-300 ease-in-out first:rounded-t-md last:rounded-b-md last:border-none hover:bg-slate-100 first:hover:rounded-t-md last:hover:rounded-b-md dark:border-slate-700 dark:hover:bg-slate-700"
                    x-on:keyup.down="$refs.searchField.focus()">
                    @if ($result->title)
                        <a href="{{ route('story.show', $result->slug) }}"
                            class="block px-3 py-2 text-base text-gray-900 dark:text-slate-200">
                            <div class="flex items-center">
                                <div class="mr-3">
                                    <x-icons.search class="h-6 w-6 text-gray-300" />
                                </div>
                                <div>{!! Str::limit($result->title, 38, ' ...') !!}</div>
                            </div>
                        </a>
                    @else
                        <a href="{{ $result->username ? route('user.show', $result) : route('community.show', ['community' => $result->slug]) }}"
                            class="block px-3 py-2 text-base text-gray-900 dark:text-slate-200">
                            <div class="flex items-center">
                                <img class="mr-3 h-6 w-6 rounded object-cover shadow"
                                    src="{{ $result->getAvatar() }}"
                                    alt="{{ $result->name }}" />
                                <div>{!! Str::limit($result->name, 38, ' ...') !!}</div>
                            </div>
                        </a>
                    @endif
                </li>
            @empty
                <li class="block px-3 py-1 text-gray-900 dark:text-slate-200">
                    <div class="flex items-center">
                        <div class="mr-3">
                            <x-icons.emoji.sad class="h-6 w-6 text-gray-300" />
                        </div>
                        <div>{{ __('No results') }}</div>
                    </div>
                </li>
            @endforelse
        </ul>
    @endif
</div>
