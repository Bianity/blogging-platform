<x-setup-layout :title="__('Account Configuration')">
    <div class="row justify-content-center rounded-lg bg-white p-6 shadow-sm">
        <div class="text-gray-900">
            <h1 class="mb-3 text-center text-xl font-semibold">
                {{ __('Account Configuration') }}
            </h1>
            <form action="{{ route('setup.save-account') }}" method="POST">
                @csrf

                <section class="my-4">
                    <h2 class="mb-2 text-lg font-semibold">{{ __('Create admin account') }}</h2>
                    <div class="mb-3">
                        <x-input type="text" name="username" label="{{ __('Enter your username') }}"
                            value="{{ old('username') }}" />
                    </div>

                    <div class="mb-3">
                        <x-input type="email" name="email" label="{{ __('Enter your email') }}"
                            value="{{ old('email') }}" />
                    </div>

                    <div class="mb-3">
                        <x-input type="password" name="password" label="{{ __('Enter a strong password') }}"
                            value="{{ old('password') }}" />
                    </div>
                    <x-input type="password" name="password_confirmation" label="{{ __('Confirm your password') }}"
                        value="{{ old('password_confirmation') }}" />
                </section>


                <section class="mt-5 mb-2">
                    <x-button type="submit" outline primary>
                        {{ __('Install') }}
                    </x-button>
                </section>
            </form>
        </div>
    </div>
</x-setup-layout>
