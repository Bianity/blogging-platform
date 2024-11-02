<div>
    <a href="#" onclick="$openModal('reportModal')"
        class="hover:shadow-xs block rounded px-5 py-2 transition duration-100 ease-in hover:bg-slate-100 dark:hover:bg-slate-700">
        {{ __('Report Abuse') }}
    </a>

    <x-modal.card z-50 max-width="md" title="{{ __('Report Abuse') }}" blur wire:model="reportModal">
        <p>{{ __('Thank you for reporting any abuse that violates our code of conduct or terms and conditions.') }}</p>
        <div class="mt-4">
            <x-input type="hidden" wire:model="story" />
            <x-select
                searchable="0"
                placeholder="{{ __('Сhoose a reason') }}"
                class="border-gray-100 shadow-none hover:border-primary-500 focus:border-primary-500 focus:shadow"
                wire:model="reason">
                <x-select.option label="{{ __('Spam') }}" value="Spam" />
                <x-select.option label="{{ __('Abuse') }}" value="Abuse" />
                <x-select.option label="{{ __('Harassment') }}" value="Harassment" />
                <x-select.option label="{{ __('Law violation') }}" value="Law violation" />
                <x-select.option label="{{ __('Sexual content') }}" value="Sexual content" />
                <x-select.option label="{{ __('Copyright issue') }}" value="Copyright issue" />
                <x-select.option label="{{ __('Other') }}" value="Other" />
            </x-select>
        </div>

        <div class="mt-4">
            <x-forms.label for="reportMessage">{{ __('Message') }}</x-forms.label>
            <x-forms.textarea-full-constrained wire:model="message" name="reportMessage" rows="4"
                id="reportMessage" limit="500" />
            <p class="ml-2 mt-2 text-sm text-gray-500">
                {{ __('Please provide any additional information or context that will help us understand and handle the situation.') }}
            </p>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-buttons.default-button @click="close">{{ __('Cancel') }}</x-buttons.default-button>
                <x-buttons.primary-button wire:click="report"
                    x-on:click="{{ !$errors ?? close }}">{{ __('Send') }}
                </x-buttons.primary-button>
            </div>
        </x-slot>
    </x-modal.card>
</div>
