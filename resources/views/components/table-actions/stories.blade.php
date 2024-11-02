<div class="flex items-center gap-x-5">
    <button
        title="{{ __('Delete') }}"
        x-on:confirm="{
					title: '{{ __('Delete Story?') }}',
					description: '{{ __('Are you sure you want to delete this story? This action will erase entry. Even another author, because you have permissions.') }}',
					icon: 'error',
					iconColor: 'text-red-500',
					iconBackground: 'bg-transparent',
					accept: {
							label: '{{ __('Delete') }}',
							method: 'deleteStory',
							params: {{ $row->id }}
					},
					params: 1
}">
        <x-icon name="trash"
            class="h-5 w-5 text-red-500 hover:scale-105 hover:text-red-600 dark:text-red-400 dark:hover:text-red-500" />
    </button>

    @isset($row->published_at)
        @if ($row->featured === 0)
            <button
                title="{{ __('Featured Story') }}"
                x-on:confirm="{
									title: '{{ __('Featured Story?') }}',
									description: '{{ __('Add this story to featured collection?') }}',
									icon: 'question',
									iconColor: 'text-info-500',
									iconBackground: 'bg-transparent',
									accept: {
									label: '{{ __('Add') }}',
									method: 'isFeatured',
									params: {{ $row->id }}
									},
									params: 1
									}">
                <x-icon name="star"
                    class="h-5 w-5 text-yellow-500 hover:scale-105 hover:text-yellow-600 dark:text-yellow-400 dark:hover:text-yellow-500" />
            </button>
        @else
            <button
                title="{{ __('Remove from featured') }}"
                x-on:confirm="{
									title: '{{ __('Remove from featured?') }}',
									description: '{{ __('This action will remove the story from featured collection?') }}',
									icon: 'question',
									iconColor: 'text-info-500',
									iconBackground: 'bg-transparent',
									accept: {
									label: '{{ __('Remove') }}',
									method: 'isFeatured',
									params: {{ $row->id }}
									},
									params: 1
									}">
                <x-icon name="star" solid
                    class="h-5 w-5 text-yellow-500 hover:scale-105 hover:text-yellow-600 dark:text-yellow-400 dark:hover:text-yellow-500" />
            </button>
        @endif
    @endisset
</div>
