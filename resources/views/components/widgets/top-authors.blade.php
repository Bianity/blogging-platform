<section class="rounded-lg bg-white dark:bg-slate-800">
    <h2 class="py-2 px-4 text-base font-semibold text-gray-900 dark:text-slate-200">
        {{ __('Top authors') }}
    </h2>
    <div class="divide-y divide-gray-100 dark:divide-slate-800">
        @foreach ($topAuthors as $author)
            <a href="{{ route('user.show', $author->username) }}"
                class="flex items-center space-x-3 py-2 px-4 transition duration-200 ease-in-out hover:bg-gray-50 last:hover:rounded-b-lg dark:hover:bg-slate-700">
                <div class="flex-shrink-0">
                    <x-users.avatar-circle :user="$author" />
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-900 dark:text-slate-200">
                        {{ $author->name ? $author->name : $author->username }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-slate-300">
                        {{ $author->stories_count }}
                        {{ __('Stories') }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <div
                        class="{ @if ($loop->first) bg-primary-500 text-white @else text-black bg-slate-100 dark:bg-slate-600 @endif } flex h-8 w-8 items-center justify-center gap-x-3 rounded-full text-base font-semibold dark:text-slate-100">
                        {{ $loop->iteration }}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
