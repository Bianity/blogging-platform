<x-guest-layout :title="__('Login')">
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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="relative mb-4 mt-2">
                    <x-forms.label for="email" :value="__('Email')" />
                    <x-forms.input id="email" class="mt-1 block w-full" type="email" name="email"
                        :value="old('email')"
                        autofocus />
                </div>

                <div class="relative mb-4 mt-2">
                    <x-forms.label for="password" :value="__('Password')" />
                    <x-forms.input id="password" class="mt-1 block w-full"
                        type="password"
                        name="password"
                        autocomplete="current-password" />
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <x-forms.checkbox id="remember_me" name="remember" />
                        <label for="remember_me"
                            class="ml-2 flex cursor-pointer items-center text-sm leading-5 hover:text-secondary-900 dark:hover:text-secondary-300">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        @if (Route::has('password.request'))
                            <a class="text-sm font-normal text-secondary-600 hover:text-primary-500 dark:text-slate-400"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mt-5 block">
                    <x-buttons.primary-button class="h-11 w-full">
                        {{ __('Sign in') }}
                    </x-buttons.primary-button>
                </div>
                @if ($advancedSettings->facebook_login_active !== false || $advancedSettings->google_login_active !== false)
                    <div class="pb-5 pt-7 text-center">
                        <h6 class="font-base relative inline-block pl-1 pr-1 text-sm text-gray-400">
                            <span>{{ __('Sign in with social accounts') }}</span>
                        </h6>
                    </div>
                @endif
                <div class="flex items-center space-x-3">
                    @if ($advancedSettings->facebook_login_active !== false)
                        <x-buttons.default-button href="{{ url('/auth/facebook') }}" class="w-full text-gray-700">
                            <x-icons.social.facebook-login class="mr-3 h-6 w-6" />
                            {{ __('Facebook') }}
                        </x-buttons.default-button>
                    @endif
                    @if ($advancedSettings->google_login_active !== false)
                        <x-buttons.default-button href="{{ url('/auth/google') }}" class="w-full text-gray-700">
                            <x-icons.social.google-login class="mr-3 h-6 w-6" />
                            {{ __('Google') }}
                        </x-buttons.default-button>
                    @endif
                </div>
            </form>
            <x-slot name="footer">
                <div class="space-x-2">
                    <span>{{ __('Don\'t have an account?') }}</span>
                    <a href="{{ route('register') }}"
                        class="text-sm font-bold text-primary-500 hover:text-primary-600">{{ __('Sign Up') }}</a>
                </div>
            </x-slot>
        </x-forms.auth-card>
    </div>
</x-guest-layout>
