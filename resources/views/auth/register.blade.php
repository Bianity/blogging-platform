<x-guest-layout :title="__('Register')">
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

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                @if ($advancedSettings->recaptcha_active !== false)
                    <input type="hidden" class="g-recaptcha" name="recaptcha_token" id="recaptcha_token">
                @endif
                <!-- Name -->
                <div>
                    <x-forms.label for="name" :value="__('Name')" />
                    <x-forms.input id="name" class="mt-1 block w-full" type="text" name="name"
                        :value="old('name')"
                        autofocus />
                </div>

                <!-- Username -->
                <div class="mt-4">
                    <x-forms.label for="username" :value="__('Username')" />
                    <x-forms.input id="username" class="mt-1 block w-full" type="text" name="username"
                        :value="old('username')" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-forms.label for="email" :value="__('Email')" />
                    <x-forms.input id="email" class="mt-1 block w-full" type="email" name="email"
                        :value="old('email')" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-forms.label for="password" :value="__('Password')" />
                    <x-forms.input id="password" class="mt-1 block w-full"
                        type="password"
                        name="password"
                        autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-forms.label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-forms.input id="password_confirmation" class="mt-1 block w-full"
                        type="password"
                        name="password_confirmation" />
                </div>

                <div class="mt-5 block">
                    <x-buttons.primary-button class="h-11 w-full">
                        {{ __('Register') }}
                    </x-buttons.primary-button>
                </div>
            </form>
            <x-slot name="footer">
                <div class="space-x-2">
                    <span>{{ __('Already registered?') }}</span>
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-primary-500 hover:text-primary-600"
                        aria-label="{{ __('Already registered?') }}">{{ __('Sign In') }}</a>
                </div>
            </x-slot>
        </x-forms.auth-card>
    </div>
    @if ($advancedSettings->recaptcha_active !== false)
        @push('scripts')
            <script>
                grecaptcha.ready(function() {
                    document.getElementById('registerForm').addEventListener("submit", function(event) {
                        event.preventDefault();
                        grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
                                action: 'register'
                            })
                            .then(function(token) {
                                document.getElementById("recaptcha_token").value = token;
                                document.getElementById('registerForm').submit();
                            });
                    });
                });
            </script>
        @endpush
    @endif
</x-guest-layout>
