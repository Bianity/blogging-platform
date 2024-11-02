<x-modal.card title="{{ __('Poll') }}" blur max-width="3xl" wire:model="addPollModal">
    <form wire:submit="savePoll">
        @csrf
        <div class="p-2">
            <div>
                <x-input
                    wire:model='question'
                    placeholder="{{ __('Ask a question...') }}"
                    type="text" />
            </div>
            <ul class="mt-5 flex-col space-y-3">
                @foreach ($choices as $choice)
                    <li>
                        <div class="flex items-center gap-4">
                            <div class="grow">
                                <x-input wire:model='choices.{{ $loop->index }}.text'
                                    placeholder="{{ __('Choice') . $loop->index + 1 }}"
                                    type="text" />
                            </div>
                            <x-button outline negative label="x"
                                wire:click="removeChoice({{ $loop->index }})" />
                        </div>
                    </li>
                @endforeach
            </ul>
            @if (sizeof($choices) < $maxChoices)
                <div class="my-4">
                    <div class="flex items-center gap-4">
                        <div class="grow">
                            <x-input wire:model="text" type="text"
                                placeholder="{{ __('Choice') . ' ' . sizeof($choices) + 1 }}" />
                        </div>
                        <x-button type="button" outline positive label="+"
                            wire:click="addChoice" />
                    </div>
                    @error('choices')
                        <small
                            class="border-red-300 text-red-500 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 dark:border-red-300 dark:bg-red-900 dark:bg-opacity-20">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            @endif

            <div class="mt-5">
                <x-datetime-picker
                    :min="now()"
                    :max="now()->addDays(5)"
                    without-timezone
                    placeholder="{{ __('Poll ends') }}"
                    parse-format="YYYY-MM-DD HH:mm"
                    wire:model="pollEnds" />
            </div>
            <div class="mt-5">
                <x-forms.label class="mb-2 text-base font-semibold">
                    {{ __('Poll style') }}
                </x-forms.label>
                <div class="flex flex-col items-center justify-between gap-1 sm:flex-row">
                    <label class="cursor-pointer">
                        <input type="radio" class="peer sr-only" wire:model.live="pollStyle"
                            value="primary" />
                        <div
                            class="w-56 rounded-md bg-white p-2 text-gray-600 ring-2 ring-transparent transition-all hover:bg-gray-50 hover:shadow peer-checked:text-primary-600 peer-checked:ring-primary-400 peer-checked:ring-offset-2">
                            <div class="flex">
                                <div class="flex grow flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <svg width="24" height="24"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="m10.6 13.8l-2.175-2.175q-.275-.275-.675-.275t-.7.3q-.275.275-.275.7q0 .425.275.7L9.9 15.9q.275.275.7.275q.425 0 .7-.275l5.675-5.675q.275-.275.275-.675t-.3-.7q-.275-.275-.7-.275q-.425 0-.7.275ZM12 22q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-end justify-between">
                                            <p class="line-clamp-1 text-lg font-bold">
                                                {{ __('Primary') }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="space-y-2 rounded border p-4">
                                        <div
                                            class="flex items-center justify-between space-x-2 pt-1">
                                            <div
                                                class="h-3 w-32 rounded bg-primary-500">
                                            </div>
                                            <div
                                                class="h-3 w-3 rounded-full bg-gray-400">
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center justify-between space-x-2 pt-1">
                                            <div
                                                class="h-3 w-20 rounded bg-primary-500">
                                            </div>
                                            <div
                                                class="h-3 w-3 rounded-full bg-gray-400">
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center justify-between space-x-2 pt-1">
                                            <div
                                                class="h-3 w-36 rounded bg-primary-500">
                                            </div>
                                            <div
                                                class="h-3 w-3 rounded-full bg-gray-400">
                                            </div>
                                        </div>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" class="peer sr-only" wire:model.live="pollStyle"
                            value="lime" />
                        <div
                            class="w-56 rounded-md bg-white p-2 text-gray-600 ring-2 ring-transparent transition-all hover:bg-gray-100 hover:shadow peer-checked:text-primary-600 peer-checked:ring-primary-400 peer-checked:ring-offset-2 dark:bg-slate-800 dark:text-slate-300 dark:peer-checked:ring-offset-0">
                            <div class="flex">
                                <div class="flex grow flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <svg width="24" height="24"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="m10.6 13.8l-2.175-2.175q-.275-.275-.675-.275t-.7.3q-.275.275-.275.7q0 .425.275.7L9.9 15.9q.275.275.7.275q.425 0 .7-.275l5.675-5.675q.275-.275.275-.675t-.3-.7q-.275-.275-.7-.275q-.425 0-.7.275ZM12 22q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-end justify-between">
                                            <p
                                                class="line-clamp-1 text-lg font-bold">
                                                {{ __('Lime') }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="space-y-2 rounded border p-4">
                                        <div
                                            class="flex items-center justify-between space-x-2 pt-1">
                                            <div
                                                class="h-3 w-32 rounded bg-gradient-to-r from-lime-500 to-lime-600">
                                            </div>
                                            <div
                                                class="h-3 w-3 rounded-full bg-gray-400">
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center justify-between space-x-2 pt-1">
                                            <div
                                                class="h-3 w-20 rounded bg-gradient-to-r from-lime-500 to-lime-600">
                                            </div>
                                            <div
                                                class="h-3 w-3 rounded-full bg-gray-400">
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center justify-between space-x-2 pt-1">
                                            <div
                                                class="h-3 w-36 rounded bg-gradient-to-r from-lime-500 to-lime-600">
                                            </div>
                                            <div
                                                class="h-3 w-3 rounded-full bg-gray-400">
                                            </div>
                                        </div>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" class="peer sr-only" wire:model.live="pollStyle"
                            value="purple" />
                        <div
                            class="w-56 rounded-md bg-white p-2 text-gray-600 ring-2 ring-transparent transition-all hover:bg-gray-50 hover:shadow peer-checked:text-primary-600 peer-checked:ring-primary-400 peer-checked:ring-offset-2">
                            <div class="flex">
                                <div class="flex grow flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <svg width="24" height="24"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="m10.6 13.8l-2.175-2.175q-.275-.275-.675-.275t-.7.3q-.275.275-.275.7q0 .425.275.7L9.9 15.9q.275.275.7.275q.425 0 .7-.275l5.675-5.675q.275-.275.275-.675t-.3-.7q-.275-.275-.7-.275q-.425 0-.7.275ZM12 22q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-end justify-between">
                                            <p class="line-clamp-1 text-lg font-bold">
                                                {{ __('Purple') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <div
                                            class="space-y-2 rounded border p-4">
                                            <div
                                                class="flex items-center justify-between space-x-2 pt-1">
                                                <div
                                                    class="h-3 w-32 rounded bg-gradient-to-br from-purple-600 to-blue-500">
                                                </div>
                                                <div
                                                    class="h-3 w-3 rounded-full bg-gray-400">
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center justify-between space-x-2 pt-1">
                                                <div
                                                    class="h-3 w-20 rounded bg-gradient-to-br from-purple-600 to-blue-500">
                                                </div>
                                                <div
                                                    class="h-3 w-3 rounded-full bg-gray-400">
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center justify-between space-x-2 pt-1">
                                                <div
                                                    class="h-3 w-36 rounded bg-gradient-to-br from-purple-600 to-blue-500">
                                                </div>
                                                <div
                                                    class="h-3 w-3 rounded-full bg-gray-400">
                                                </div>
                                            </div>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button negative outline label="{{ __('Cancel') }}" wire:click="cancelAddPoll" />
            <x-button primary label="{{ __('Save') }}" x-on:click="{{ $errors ? '' : close }}"
                wire:click="savePoll" />
        </div>
    </x-slot>
</x-modal.card>
