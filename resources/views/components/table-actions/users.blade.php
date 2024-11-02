<div class="flex items-center gap-x-5">
    <a href="{{ route('admin.users.edit', $row) }}" title="{{ __('Edit') }}">
        <x-icon name="pencil-alt"
            class="h-5 w-5 text-gray-500 hover:scale-105 hover:text-gray-600 dark:text-slate-200 dark:hover:text-slate-100" />
    </a>
    @can('ban', $row)
        @if ($row->banned_at != null)
            <button
                title="{{ __('Unban user?') }}"
                x-on:confirm="{
									title: '{{ __('Unban user?') }}',
									description: '{{ __('Unbanning this user will allow them to login again and post content.') }}',
									icon: 'question',
									iconColor: 'text-info-500',
									iconBackground: 'bg-transparent',
									accept: {
									label: '{{ __('Unban') }}',
									method: 'isBanned',
									params: {{ $row->id }}
									},
									params: 1
									}">
                <x-icon name="check-circle"
                    class="h-5 w-5 text-emerald-500 hover:scale-105 hover:text-emerald-600 dark:text-emerald-400 dark:hover:text-emerald-500" />
            </button>
        @else
            <button
                title="{{ __('Ban user?') }}"
                x-on:confirm="{
									title: '{{ __('Ban user?') }}',
									description: '{{ __('Banning this user will prevent them from logging in, posting content.') }}',
									icon: 'question',
									iconColor: 'text-info-500',
									iconBackground: 'bg-transparent',
									accept: {
									label: '{{ __('Ban') }}',
									method: 'isBanned',
									params: {{ $row->id }}
									},
									params: 1
									}">
                <x-icon name="ban"
                    class="h-5 w-5 text-red-500 hover:scale-105 hover:text-red-600 dark:text-red-400 dark:hover:text-red-500" />
            </button>
        @endif
    @endcan
    @if (!$row->hasRole('administrator'))
        <button
            title="{{ __('Delete') }}"
            x-on:confirm="{
					title: '{{ __('Delete User?') }}',
					description: '{{ __('Are you sure you want to delete this user? This action will erase entry.') }}',
					icon: 'error',
					iconColor: 'text-red-500',
					iconBackground: 'bg-transparent',
					accept: {
					label: '{{ __('Delete') }}',
					method: 'deleteUser',
					params: {{ $row->id }}
					},
					params: 1
					}">
            <x-icon name="trash"
                class="h-5 w-5 text-red-500 hover:scale-105 hover:text-red-600 dark:text-red-400 dark:hover:text-red-500" />
        </button>
    @endif
</div>
