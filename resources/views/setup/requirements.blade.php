<x-setup-layout :title="__('Requirements')">
    <div class="row justify-content-center rounded-lg bg-white p-6 shadow-sm">
        <div class="text-gray-900">
            <h1 class="text-center text-xl font-semibold">
                {{ __('Requirements') }}
            </h1>
            <section class="mt-5">
                @foreach ($results as $key => $successful)
                    @if ($key == 'php_version')
                        <div
                            class="items-centerflex flex items-center justify-between border-b border-slate-100 py-3">
                            <div class="font-semibold">{{ __('Current PHP Version') }}
                                <span>{{ $results['php_version']['current'] }}</span>
                            </div>
                            @if ($successful['acceptable'])
                                <x-icon name="check-circle" class="h-5 w-5 text-emerald-500" solid />
                            @else
                                <x-icon name="exclamation-circle" class="h-5 w-5 text-red-600" solid />
                            @endif

                        </div>
                    @endif
                @endforeach
            </section>

            <section class="mt-5">
                <div class="text-xl font-semibold">{{ __('PHP Extensions') }}</div>
                @foreach ($results['extensions'] as $key => $successful)
                    <div
                        class="items-centerflex flex items-center justify-between border-b border-slate-100 py-3">
                        <div class="font-semibold">{{ $key }}</div>
                        @if ($successful)
                            <x-icon name="check-circle" class="h-5 w-5 text-emerald-500" solid />
                        @else
                            <x-icon name="exclamation-circle" class="h-5 w-5 text-red-600" solid />
                        @endif
                    </div>
                @endforeach
            </section>

            <section class="mt-5">
                <div class="text-xl font-semibold">{{ __('Writable Permissions') }}</div>
                @foreach ($results as $key => $successful)
                    @if ($key == 'writable')
                        <div
                            class="items-centerflex flex items-center justify-between border-b border-slate-100 py-3">
                            <div class="font-semibold">.env</div>
                            @if ($successful)
                                <x-icon name="check-circle" class="h-5 w-5 text-emerald-500" solid />
                            @else
                                <x-icon name="exclamation-circle" class="h-5 w-5 text-red-600" solid />
                            @endif
                        </div>
                    @endif
                    @if ($key == 'writable')
                        <div
                            class="items-centerflex flex items-center justify-between border-b border-slate-100 py-3">
                            <div class="font-semibold">/storage</div>
                            @if ($successful)
                                <x-icon name="check-circle" class="h-5 w-5 text-emerald-500" solid />
                            @else
                                <x-icon name="exclamation-circle" class="h-5 w-5 text-red-600" solid />
                            @endif
                        </div>
                    @endif
                @endforeach
            </section>

            <div class="mt-5 mb-2">
                @if ($success)
                    <x-button href="{{ route('setup.database') }}" outline primary
                        label="{{ __('Continue') }}" />
                @else
                    <x-button type="button" outline negative
                        label="{{ __('Continue') }}" disabled />
                @endif
            </div>
        </div>
    </div>
</x-setup-layout>
