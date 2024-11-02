<x-setup-layout :title="__('Setup wizard')">
    <div class="row justify-content-center rounded-lg bg-white p-6 shadow-sm">
        <div class="text-gray-900">
            <h1 class="mb-3 text-center text-xl font-semibold">
                {{ __('Welcome to Alma setup wizard') }}
            </h1>
            <section>
                <div class="mb-3">
                    {{ __('In the following steps you will set up Alma to be ready to use.') }}
                </div>
                <div class="mb-2">
                    {{ __('1. Check if all server requirements are met.') }}
                </div>
                <div class="mb-2">
                    {{ __('2. Check database connection is successful and setup. You will need to know the following items.') }}
                    <ul class="list-outside list-disc pl-8">
                        <li>{{ __('Database name') }}</li>
                        <li>{{ __('Database username') }}</li>
                        <li>{{ __('Database password') }}</li>
                        <li>{{ __('Database host') }}</li>
                    </ul>
                </div>
                <div>
                    {{ __('3. Create your admin account.') }}
                </div>
            </section>

            <div class="mt-5 mb-2">
                <x-button href="{{ route('setup.requirements') }}" primary outline
                    label="{!! __('Let\'s go!') !!}" />
            </div>
        </div>
    </div>
</x-setup-layout>
