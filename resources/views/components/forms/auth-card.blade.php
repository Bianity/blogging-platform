<div class="flex min-h-screen w-full flex-col items-center justify-center sm:max-w-4xl">
    <div>
        {{ $logo }}
    </div>
    <div
        class="mt-6 w-full overflow-hidden px-6 py-4 dark:bg-gray-800 dark:bg-opacity-40 sm:rounded-lg">
        {{ $slot }}
    </div>
    <div class="fixed bottom-0 left-0 right-0 flex h-16 items-center justify-center border-t border-primary-300">
        {{ $footer }}
    </div>
</div>
