<x-guest-layout :title="__('Verify Email')">
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
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div>
                        <x-buttons.primary-button class="h-11 w-full">
                            {{ __('Resend Verification Email') }}
                        </x-buttons.primary-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-buttons.default-button class="h-11 w-full">
                        {{ __('Log Out') }}
                    </x-buttons.default-button>
                </form>
            </div>
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
