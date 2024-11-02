@if ($story->isPublished() && $story->isCommunities())
    <div
        class="-mt-6 mb-5 rounded-t-lg bg-slate-50 py-2 text-black dark:bg-primary-900 dark:bg-opacity-20 dark:text-white sm:p-4">
        <div class="w-content flex items-center space-x-3">
            @isset($story->community->avatar)
                <a href="{{ route('community.show', ['community' => $story->community->slug]) }}">
                    <img class="mr-3 h-6 w-6 rounded"
                        src="{{ $story->community->getAvatar() }}"
                        alt="{{ $story->community->name }}">
                </a>
            @endisset
            <div class="flex items-center">
                <span class="mr-1">{{ __('Published in') }}</span>
                <a href="{{ route('community.show', ['comunity' => $story->community->slug]) }}"
                    class="block min-w-[90px] font-bold text-primary-600"> {{ $story->community->name }}</a>
            </div>
        </div>
    </div>
@elseif($story->isNotPublished())
    @can('update', $story)
        <div
            class="-mt-6 mb-5 flex flex-col rounded-t-lg bg-red-100 p-4 text-black sm:flex-row sm:items-center sm:justify-between">
            <div class="mr-3 flex flex-col">
                <div class="font-bold">{{ __('Unpublished story.') }}</div>
                <div class="text-sm">{{ __('This URL is public but secret, so share at your own wish.') }}</div>
            </div>

    @endcan
@else
@endif
