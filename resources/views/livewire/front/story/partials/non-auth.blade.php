<div class="w-content py-5">
    <h2>{{ __('Login to access content') }}</h2>
    <div class="mt-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <x-buttons.secondary-button class="h-11 w-full" href="{{ route('register') }}">
            {{ __('Register') }}
        </x-buttons.secondary-button>
        <x-buttons.primary-button class="h-11 w-full" href="{{ route('login') }}">
            {{ __('Log in') }}
        </x-buttons.primary-button>
    </div>
</div>
