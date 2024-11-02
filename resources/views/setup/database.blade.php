<x-setup-layout :title="__('Database Configuration')">
    <div class="row justify-content-center rounded-lg bg-white p-6 shadow-sm">
        <div class="text-gray-900">
            <h1 class="mb-3 text-center text-xl font-semibold">
                {{ __('Database Configuration') }}
            </h1>

            {{-- <livewire:flash-container /> --}}

            <form action="{{ route('setup.save-database') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <x-input name="db_host" label="{{ __('Database Host') }}" placeholder="localhost"
                        value="{{ old('db_host') ?: env('DB_HOST', 'localhost') }}" required />
                </div>

                <div class="mb-3">
                    <x-input name="db_port" label="{{ __('Database Port') }}" placeholder="3306"
                        value="{{ old('db_port') ?: env('DB_PORT', 3306) }}" required />
                </div>

                <div class="mb-3">
                    <x-input name="db_name" label="{{ __('Database Name') }}"
                        value="{{ old('db_name') ?: env('DB_DATABASE') }}" required />
                </div>

                <div class="mb-3">
                    <x-input name="db_user" label="{{ __('Database User') }}"
                        value="{{ old('db_user') }}" required />
                </div>

                <div class="mb-3">
                    <x-input name="db_password" label="{{ __('Database Password') }}"
                        value="{{ old('db_password') }}" />
                </div>

                @if (session('data_present', false))
                    <div class="mb-3 flex">
                        <div class="flex h-5 items-center">
                            <input id="overwrite_data" aria-describedby="overwrite_data" type="checkbox"
                                name="overwrite_data" value="0"
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary-600 focus:ring-2 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600">
                        </div>
                        <div class="ml-2 text-sm">
                            <label for="overwrite_data"
                                class="font-medium text-gray-900 dark:text-gray-300">{{ __('I confirm that all data should be deleted and overwritten with a new database') }}</label>
                        </div>
                    </div>
                @endif

                <section class="mb-2 mt-5">
                    <x-button type="submit" outline primary>
                        @if ($errors->any())
                            {{ __('Try again') }}
                        @else
                            {{ __('Submit') }}
                        @endif
                    </x-button>
                </section>
            </form>
        </div>
    </div>
</x-setup-layout>
