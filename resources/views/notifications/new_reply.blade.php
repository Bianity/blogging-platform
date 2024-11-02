@php($data = $notification->data)
<li>
    <a href="{{ route('story.show', $data['story_slug']) }}"
        @click.prevent="isOpen = false"
        wire:click.prevent="markAsRead('{{ $notification->id }}')"
        class="flex px-10 py-3 transition duration-150 ease-in hover:bg-slate-100 dark:hover:bg-slate-700 md:px-5">
        <img src="{{ $data['user_avatar'] }}" alt="avatar"
            class="h-10 w-10 rounded-xl" />
        <div class="ml-4">
            <div class="flex items-center justify-between">
                <div class="font-semibold">{{ $data['user_name'] }}</div>
                <div class="text-xs text-gray-400">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>
            <div class="line-clamp-6">
                <span class="text-xs"><span class="mr-1 font-medium">{{ __('Replied on') }}</span><span
                        class="font-semibold">{{ $data['story_title'] }}</span></span>
                <div class="p-1 text-sm font-semibold">{{ $data['reply_body'] }}</div>
            </div>
        </div>
    </a>
</li>
