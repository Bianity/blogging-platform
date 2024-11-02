<div class="flex items-center gap-x-5">
    <button
        title="{{ __('Delete') }}"
        x-on:confirm="{
				title: '{{ __('Delete this message?') }}',
				description: '{{ __('Are you sure you want to delete this message? This action will erase entry.') }}',
				icon: 'error',
				iconColor: 'text-red-500',
				iconBackground: 'bg-transparent',
				accept: {
						label: '{{ __('Delete') }}',
						method: 'deleteMessage',
						params: {{ $row->id }}
				},
				params: 1
			}">
        <x-icon name="trash"
            class="h-5 w-5 text-red-500 hover:scale-105 hover:text-red-600 dark:text-red-400 dark:hover:text-red-500" />
    </button>
</div>
