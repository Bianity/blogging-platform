@if ($featuredStories->isNotEmpty())
    <div
        class="mb-5 block bg-white px-4 py-5 hover:shadow-card dark:bg-slate-800 dark:text-slate-200 sm:rounded-lg">
        <div class="relative mb-2 flex items-center border-b pb-2 dark:border-slate-700">
            <span class="relative flex h-2 w-2">
                <span
                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-primary-500"></span>
            </span>
            <div class="ml-3 text-sm font-medium">
                {{ __('Featured stories') }}
            </div>
        </div>
        <ul role="list"
            class="space-y-4">
            @foreach ($featuredStories as $featuredStory)
                <li><a href="{{ route('story.show', $featuredStory->slug) }}"
                        class="text-base font-semibold leading-4 hover:text-blue-400">{{ $featuredStory->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
