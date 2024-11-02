<div class="md:col-span-1 flex justify-between border-b border-gray-300">
    <div class="py-3 px-6">
        <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ $description }}
        </p>
    </div>

    <div class="px-6">
        {{ $aside ?? '' }}
    </div>
</div>
