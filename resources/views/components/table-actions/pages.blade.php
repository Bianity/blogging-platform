<div class="flex items-center gap-x-5">
    <a href="{{ route('admin.pages.edit', $row) }}" title="{{ __('Edit') }}">
        <x-icon name="pencil-alt"
            class="h-5 w-5 text-gray-500 hover:scale-105 hover:text-gray-600 dark:text-slate-200 dark:hover:text-slate-100" />
    </a>
    <button
        title="{{ __('Delete') }}"
        x-on:confirm="{
			title: '{{ __('Delete Page?') }}',
			description: '{{ __('Are you sure you want to delete this page? This action will erase your entry.') }}',
			icon: 'error',
			iconColor: 'text-red-500',
			iconBackground: 'bg-transparent',
			accept: {
					label: '{{ __('Delete') }}',
					method: 'deletePage',
					params: {{ $row->id }}
			},
			params: 1
	}">
        <x-icon name="trash"
            class="h-5 w-5 text-red-500 hover:scale-105 hover:text-red-600 dark:text-red-400 dark:hover:text-red-500" />
    </button>
</div>
