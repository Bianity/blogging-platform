<x-setup-layout :title="__('Complete')">
    <div class="row justify-content-center rounded-lg bg-white p-6 shadow-sm">
        <div class="text-gray-900">
            <h1 class="mb-3 text-center text-xl font-semibold">
                {{ __('Your Alma script successfully installed!') }}
            </h1>
            <div class="my-4 border-b border-gray-200"></div>

            <div class="mt-5 mb-2 text-center">
                <x-button href="{{ route('home') }}" primary outline
                    label="{{ __('Visit site') }}" />
            </div>
        </div>
    </div>
</x-setup-layout>
