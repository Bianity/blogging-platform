<div x-data="{ tab: 'profile' }"
    class="relative mx-auto flex w-full flex-col-reverse sm:pt-6 md:grid md:max-w-theme md:grid-cols-12 md:gap-8">
    <div class="col-span-8 bg-white p-4 shadow dark:bg-slate-800 dark:text-slate-200 sm:rounded-lg">
        <a class="flex items-center text-gray-500 hover:text-primary-700"
            href="{{ route('community.show', ['community' => $community->slug]) }}">
            <x-icons.arrow-left class="h-6 w-6" />
            <span class="ml-1">{{ $community->name }}</span>
        </a>
        <div x-show="tab === 'profile'" x-cloak>
            <div class="mt-6">
                <form wire:submit="updateCommunity">
                    <section x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                        <div class="flex items-center justify-between">
                            <x-forms.label for="communityName" class="mb-2 text-lg font-semibold">
                                {{ __('Community name') }}</x-forms.label>
                            <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                    x-html="count"></span> / <span
                                    x-html="$refs.countme.maxLength"></span>
                            </span>
                        </div>
                        <x-forms.input
                            wire:model="communityName"
                            id="communityName"
                            name="communityName"
                            type="text"
                            maxlength="30"
                            x-ref="countme"
                            x-on:keyup="count = $refs.countme.value.length" />
                    </section>

                    <section class="mt-6" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                        <div class="flex items-center justify-between">
                            <x-forms.label for="communityDescription" class="mb-2 text-lg font-semibold">
                                {{ __('Community description') }}</x-forms.label>
                            <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                    x-html="count"></span> / <span
                                    x-html="$refs.countme.maxLength"></span>
                            </span>
                        </div>
                        <x-forms.textarea
                            wire:model="communityDescription"
                            id="communityDescription"
                            rows=4
                            name="communityDescription"
                            maxlength="200"
                            x-ref="countme"
                            x-on:keyup="count = $refs.countme.value.length"></x-forms.textarea>
                    </section>

                    <section class="mt-6" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                        <div class="flex items-center justify-between">
                            <x-forms.label for="communityRules" class="mb-2 text-lg font-semibold">
                                {{ __('Community rules') }}</x-forms.label>
                            <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                    x-html="count"></span> / <span
                                    x-html="$refs.countme.maxLength"></span>
                            </span>
                        </div>
                        <x-forms.textarea
                            wire:model="communityRules"
                            id="communityRules"
                            rows=8
                            name="communityRules"
                            maxlength="1000"
                            x-ref="countme"
                            x-on:keyup="count = $refs.countme.value.length"></x-forms.textarea>
                    </section>

                    <section class="mt-6">
                        <x-buttons.primary-button>{{ __('Update') }}</x-buttons.primary-button>
                    </section>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-4 mb-6 md:mt-0">
        <div class="bg-white p-4 shadow dark:bg-slate-800 dark:text-slate-200 sm:rounded-lg">
            <div class="mb-3 font-bold">{{ __('Settings') }}</div>
            <div class="flex flex-col text-gray-700 dark:text-white">
                <button
                    class="-mx-4 flex items-center px-4 py-3 hover:bg-primary-50 dark:hover:bg-primary-800 dark:hover:text-white"
                    @click="tab = 'profile'"
                    :class="{
                        'text-black dark:text-white font-semibold bg-primary-100 dark:bg-primary-900': tab ===
                            'profile'
                    }">
                    <x-icons.user.settings class="mr-3 h-6 w-6" />
                    <span>{{ __('Community profile') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
