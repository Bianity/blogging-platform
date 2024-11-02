<div class="mx-auto flex w-full flex-col gap-y-8 py-4">
    <x-heading>
        <x-slot name="title">
            {{ __('Generate sitemap') }}
        </x-slot>

        <x-slot name="action">
            <x-filament::button wire:click="update" spinner="update"
                loading-delay="short">
                {{ __('Update sitemap') }}
            </x-filament::button>
        </x-slot>
    </x-heading>

    <div class="rounded-xl bg-white p-6 shadow dark:bg-gray-900 sm:overflow-hidden">
        <div class="flex flex-col gap-4">
            <div class="mb-4 flex gap-2 rounded-lg bg-gray-100 p-4 text-sm dark:bg-gray-700"
                role="alert">
                <x-icon name="exclamation"
                    class="hidden h-10 w-10 shrink-0 sm:inline" />
                <div>
                    <span
                        class="font-medium">
                        {{ __('Please note that the process of creating a site map can take several minutes or even more, depending on the amount of content on your site, so after clicking the button update the site map, wait until the process is complete without leaving the page, otherwise, the process will fail!') }}
                    </span>
                </div>
            </div>
            @if (file_exists(public_path('sitemaps.xml')))
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Sitemaps:') }}</h2>
                <ul class="max-w-md list-inside space-y-4 text-gray-500 dark:text-gray-400">
                    <li class="flex flex-col items-start gap-x-2 sm:flex-row sm:items-center">
                        <span class="mr-2">{{ __('Index:') }}</span>
                        <a
                            target="_blank"
                            class="flex items-center text-primary-400 hover:text-primary-600 dark:hover:text-primary-300"
                            href="{{ env('APP_URL') . '/sitemaps.xml' }}">
                            <x-icon name="link"
                                class="mr-1 h-4 w-4 flex-shrink-0" />
                            <span>{{ env('APP_URL') . '/sitemaps.xml' }}</span>
                        </a>
                    </li>
                    <li class="flex flex-col items-start gap-x-2 sm:flex-row sm:items-center">
                        <span class="mr-2">{{ __('Base:') }}</span>
                        <a
                            target="_blank"
                            class="flex items-center text-primary-400 hover:text-primary-600 dark:hover:text-primary-300"
                            href="{{ env('APP_URL') . '/base_sitemap.xml' }}">
                            <x-icon name="link"
                                class="mr-1 h-4 w-4 flex-shrink-0" />
                            <span>{{ env('APP_URL') . '/base_sitemap.xml' }}</span>
                        </a>
                    </li>
                    <li class="flex flex-col items-start gap-x-2 sm:flex-row sm:items-center">
                        <span class="mr-2">{{ __('Stories:') }}</span>
                        <a
                            target="_blank"
                            class="flex items-center text-primary-400 hover:text-primary-600 dark:hover:text-primary-300"
                            href="{{ env('APP_URL') . '/stories_sitemap.xml' }}">
                            <x-icon name="link"
                                class="mr-1 h-4 w-4 flex-shrink-0" />
                            <span>{{ env('APP_URL') . '/stories_sitemap.xml' }}</span>
                        </a>
                    </li>
                    <li class="flex flex-col items-start gap-x-2 sm:flex-row sm:items-center">
                        <span class="mr-2">{{ __('Communities:') }}</span>
                        <a
                            target="_blank"
                            class="flex items-center text-primary-400 hover:text-primary-600 dark:hover:text-primary-300"
                            href="{{ env('APP_URL') . '/communities_sitemap.xml' }}">
                            <x-icon name="link"
                                class="mr-1 h-4 w-4 flex-shrink-0" />
                            <span>{{ env('APP_URL') . '/communities_sitemap.xml' }}</span>
                        </a>
                    </li>
                    <li class="flex flex-col items-start gap-x-2 sm:flex-row sm:items-center">
                        <span class="mr-2">{{ __('Tags:') }}</span>
                        <a
                            target="_blank"
                            class="flex items-center text-primary-400 hover:text-primary-600 dark:hover:text-primary-300"
                            href="{{ env('APP_URL') . '/tags_sitemap.xml' }}">
                            <x-icon name="link"
                                class="mr-1 h-4 w-4 flex-shrink-0" />
                            <span>{{ env('APP_URL') . '/tags_sitemap.xml' }}</span>
                        </a>
                    </li>
                    <li class="flex flex-col items-start gap-x-2 sm:flex-row sm:items-center">
                        <span class="mr-2">{{ __('Users:') }}</span>
                        <a
                            target="_blank"
                            class="flex items-center text-primary-400 hover:text-primary-600 dark:hover:text-primary-300"
                            href="{{ env('APP_URL') . '/users_sitemap.xml' }}">
                            <x-icon name="link"
                                class="mr-1 h-4 w-4 flex-shrink-0" />
                            <span>{{ env('APP_URL') . '/users_sitemap.xml' }}</span>
                        </a>
                    </li>
                    <li class="flex flex-col items-start gap-x-2 sm:flex-row sm:items-center">
                        <span class="mr-2">{{ __('Pages:') }}</span>
                        <a
                            target="_blank"
                            class="flex items-center text-primary-400 hover:text-primary-600 dark:hover:text-primary-300"
                            href="{{ env('APP_URL') . '/pages_sitemap.xml' }}">
                            <x-icon name="link"
                                class="mr-1 h-4 w-4 flex-shrink-0" />
                            <span>{{ env('APP_URL') . '/pages_sitemap.xml' }}</span>
                        </a>
                    </li>
                </ul>
                <div class="my-5 text-xl font-semibold">{{ __('Last sitemap update') }}
                    ({{ \Carbon\Carbon::parse(strtotime($sitemapUpdatedDate))->format('j F, Y - H:i') }})
                </div>
            @else
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Sitemaps:') }}</h2>
                <div>
                    {{ __('There is no sitemap yet, you can generate a new sitemap, click on the update sitemap button and wait until it is generated.') }}
                </div>
            @endif
        </div>
    </div>
</div>
