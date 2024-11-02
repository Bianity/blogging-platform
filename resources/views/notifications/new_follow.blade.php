@php($data = $notification->data)
<li>
    <a href="{{ route('user.show', $data['username']) }}"
        @click.prevent="isOpen = false"
        wire:click.prevent="markAsReadFollower('{{ $notification->id }}')"
        class="flex px-10 py-3 transition duration-150 ease-in hover:bg-slate-100 dark:hover:bg-slate-700 md:px-5">
        <img src="{{ $data['user_avatar'] }}" alt="avatar"
            class="mr-4 h-10 w-10 rounded-xl" />
        <div class="flex flex-col">
            <div class="font-semibold">{{ $data['name'] ? $data['name'] : $data['username'] }} <span
                    class="mr-1 font-medium">{{ __('started following your blog') }}</span></div>
            <div class="text-xs text-gray-400">
                {{ $notification->created_at->toFormattedDateString() }}
            </div>
        </div>
    </a>
</li>
