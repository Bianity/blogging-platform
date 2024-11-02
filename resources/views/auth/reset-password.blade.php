<x-guest-layout :title="__('Reset Password')">
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

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-forms.label for="email" :value="__('Email')" />
                    <x-forms.input id="email" class="mt-1 block w-full" type="email" name="email"
                        :value="old('email', $request->email)" required autofocus />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-forms.label for="password" :value="__('Password')" />
                    <x-forms.input id="password" class="mt-1 block w-full" type="password" name="password" required />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-forms.label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-forms.input id="password_confirmation" class="mt-1 block w-full"
                        type="password"
                        name="password_confirmation" required />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-buttons.primary-button>
                        {{ __('Reset Password') }}
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
