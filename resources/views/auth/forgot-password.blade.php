<x-guest-layout :title="__('Forgot Password')">
    <div class="relative mx-auto h-screen w-full max-w-[420px] bg-white dark:bg-slate-900" x-data="{ state: $store.darkMode.state }">
        <x-forms.auth-card>
            <x-slot name="logo">
                <a class="block h-16 max-w-[220px]" href="{{ route('home') }}" x-cloak>
                    @if ($generalSettings->site_logo !== '' && $generalSettings->site_logo_dark !== '')
                        <img src="{{ Storage::disk(getCurrentDisk())->url($generalSettings->site_logo) }}"
                            class="h-full w-full object-contain"
                            :class="{ 'hidden': $store.darkMode.state }"
                            alt="logo" />
                        <img src="{{ Storage::disk(getCurrentDisk())->url($generalSettings->site_logo_dark) }}"
                            class="h-full w-full object-contain"
                            :class="{ 'hidden': !$store.darkMode.state }"
                            alt="logo" />
                    @else
                        <img src="{{ asset('images/logo.svg') }}"
                            class="h-full w-full object-contain"
                            :class="{ 'hidden': $store.darkMode.state }"
                            alt="logo" />
                        <img src="{{ asset('images/logo-dark.svg') }}"
                            class="h-full w-full object-contain"
                            :class="{ 'hidden': !$store.darkMode.state }"
                            alt="logo" />
                    @endif
                </a>
            </x-slot>

            <div class="mb-4 text-sm text-gray-600 dark:text-slate-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- Email Address -->
                <div>
                    <x-forms.label for="email" :value="__('Email')" />
                    <x-forms.input id="email" class="mt-1 block w-full" type="email" name="email"
                        :value="old('email')"
                        required
                        autofocus />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-buttons.primary-button class="h-12 w-full">
                        {{ __('Email Password Reset Link') }}
                    </x-buttons.primary-button>
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex items-center">
                    <x-icons.arrow-left class="mr-3 h-7 w-7 text-gray-600 dark:text-primary-500" />
                    <a href="{{ route('home') }}"
                        class="text-sm font-bold text-primary-500 hover:text-primary-600">{{ __('Back to Home') }}</a>
                </div>
            </x-slot>
        </x-forms.auth-card>
    </div>
</x-guest-layout>
