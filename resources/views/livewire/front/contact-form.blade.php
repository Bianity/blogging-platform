<div class="relative">
    <div class="bg-primary_light dark:bg-secondary-800">
        <div class="container mx-auto py-10 text-center">
            <h1 class="text-5xl font-bold text-secondary-700 dark:text-slate-200">{{ __('Contact Us') }}</h1>
            <p class="dark:text-slate-400">{{ __('If you need help or have any questions') }}</p>
        </div>
    </div>

    <div class="mx-auto mt-5 w-full lg:max-w-3xl">
        <div class="rounded-md bg-white p-6 shadow dark:bg-slate-800">
            <form wire:submit="submit" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                @csrf
                <section>
                    <x-forms.label for="contact-name" class="mb-1">
                        {{ __('Full name') }}
                    </x-forms.label>
                    <x-forms.input name="name" type="text" wire:model="name" id="contact-name" />
                </section>

                <section>
                    <x-forms.label for="contact-email" class="mb-1">
                        {{ __('Email') }}
                    </x-forms.label>
                    <x-forms.input name="email" type="text" wire:model="email" id="contact-email" />
                </section>

                <section class="sm:col-span-2">
                    <x-forms.label for="contact-subject" class="mb-1">
                        {{ __('Subject') }}
                    </x-forms.label>
                    <x-forms.input name="email" type="text" wire:model="subject" id="contact-subject" />
                </section>

                <section class="sm:col-span-2">
                    <div class="flex items-center justify-between">
                        <x-forms.label for="message" class="mb-1">
                            {{ __('Message') }}
                        </x-forms.label>
                        <small class="pr-3 text-secondary-500">{{ __('max. 500 characters') }}</small>
                    </div>
                    <x-forms.textarea
                        wire:model="message"
                        id="message"
                        rows=4
                        name="message"></x-forms.textarea>
                </section>

                <section class="sm:col-span-2 sm:flex sm:justify-end">
                    <x-buttons.primary-button type="submit" class="h-12 w-full text-base sm:h-full sm:w-auto"
                        x-on:click="content = ''">
                        {{ __('Submit') }}
                    </x-buttons.primary-button>
                </section>
            </form>
        </div>

        <footer class="mt-5">
            <x-menu.footer />
        </footer>
    </div>
</div>
