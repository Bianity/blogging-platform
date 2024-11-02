<div class="flex flex-col">
    <div class="flex items-center justify-between">
        {{-- Facebook --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('story.show', ['story' => $story->slug]) }}"
            target="_blank"
            title="{{ __('Facebook') }}"
            class="font-base inline-block w-full cursor-pointer items-center rounded-tl px-5 py-4 text-sm tracking-widest text-gray-800 transition hover:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-700">
            <div class="flex items-center">
                <x-icons.social.facebook />
            </div>
        </a>
        {{-- Twitter --}}
        <a href="https://twitter.com/intent/tweet?url={{ route('story.show', ['story' => $story->slug]) }}&text={{ replaceIntentTweet($story->title) }}"
            target="_blank"
            title="{{ __('Twitter') }}"
            class="font-base inline-block w-full cursor-pointer items-center px-5 py-4 text-sm tracking-widest text-gray-800 transition hover:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-700">
            <div class="flex items-center">
                <x-icons.social.twitter />

            </div>
        </a>
        {{-- Whatsapp --}}
        <a href="https://wa.me/?text={{ $story->title }} {{ route('story.show', ['story' => $story->slug]) }}"
            target="_blank"
            title="{{ __('Whatsapp') }}"
            class="font-base inline-block w-full cursor-pointer items-center px-5 py-4 text-sm tracking-widest text-gray-800 transition hover:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-700">
            <div class="flex items-center">
                <x-icons.social.whatsapp />
            </div>
        </a>
        {{-- Telegram --}}
        <a href="https://telegram.me/share/url?url={{ route('story.show', ['story' => $story->slug]) }}&text={{ $story->title }}"
            target="_blank"
            title="{{ __('Telegram') }}"
            class="font-base inline-block w-full cursor-pointer items-center rounded-tr px-5 py-4 text-sm tracking-widest text-gray-800 transition hover:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-700">
            <div class="flex items-center">
                <x-icons.social.telegram />
            </div>
        </a>
    </div>
    <div
        class="dark:border-primary-900 flex items-center justify-center border-t border-gray-200 px-5 py-3 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700">
        <button x-data="{ clipboard: false }" class="flex items-center">
            <x-icons.link class="dark:text-primary-500 -ml-2 h-5 w-5 text-gray-500" />
            <span
                class="ml-2"
                x-clipboard.raw="{{ route('story.show', ['story' => $story->slug]) }}"
                x-on:click="clipboard = !clipboard"
                x-html="clipboard ? '{{ __('Copied!') }}' : '{{ __('Copy link') }}'">
            </span>
        </button>
    </div>
</div>
