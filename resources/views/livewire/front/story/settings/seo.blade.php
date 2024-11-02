<div class="my-6 px-3">
    <div>
        <x-forms.label for="metaTitle" class="mb-2 text-base font-semibold">{{ __('Seo Title') }}
        </x-forms.label>
        <p class="mb-2 text-xs text-gray-500">
            {{ __('The SEO Title is used in place of your Title on search engine results pages, such as a Google search. SEO titles between 40 and 50 characters with commonly searched words have the best click-through-rates.') }}
        </p>
        <x-forms.input-constrained
            type="text"
            wire:model="metaTitle"
            name="metaTitle"
            id="metaTitle"
            limit="60"
            :value="request()->routeIs('story.edit') ? $metaTitle : ''"
            placeholder="{{ __('Maximum characters are 60') }}"></x-forms.input-constrained>
    </div>
    <div class="mt-6">
        <x-forms.label for="metaDescription" class="mb-2 text-base font-semibold">{{ __('SEO Description') }}
        </x-forms.label>
        <p class="mb-2 text-xs text-gray-500">
            {{ __('The SEO Description is used in place of your Description on search engine results pages. Good SEO descriptions are between 140-156 characters long.') }}
        </p>
        <x-forms.textarea-full-constrained
            type="text"
            wire:model="metaDescription"
            name="metaDescription"
            id="metaDescription"
            limit="156"
            rows="4"
            :value="request()->routeIs('story.edit') ? $metaDescription : ''"
            placeholder="{{ __('Maximum characters are 156') }}"
            class="my-4 mt-1 block w-full rounded-lg border-gray-100 bg-gray-100 pr-10 text-sm hover:border-primary-300 hover:bg-white hover:shadow focus:border-primary-300 focus:bg-white focus:shadow focus:ring-0 focus:ring-offset-0 sm:text-base sm:leading-5">
        </x-forms.textarea-full-constrained>
    </div>
    <div class="mt-6" wire:ignore wire:key="metaKeywords">
        <x-forms.label for="metaKeywords" class="mb-2 text-base font-semibold">{{ __('Seo Keywords') }}
        </x-forms.label>
        <x-forms.input
            type="text"
            name="metaKeywords"
            id="metaKeywords"
            wire:model="metaKeywords"
            placeholder="{{ __('Add up 10 keywords...') }}"></x-forms.input>
    </div>
    <div class="mt-6">
        <x-forms.label for="metaCanonicalUrl" class="mb-2 text-base font-semibold">
            {{ __('Canonical URL') }}
        </x-forms.label>
        <p class="text-xs text-gray-500">
            {{ __('Change meta tag ') }}
            <code class="font-semibold">canonical_url</code>
            {{ __(' if this post was first published elsewhere (like your own blog).') }}
        </p>
        <x-forms.input wire:model="metaCanonicalUrl" id="metaCanonicalUrl"
            type="text" name="metaCanonicalUrl">
        </x-forms.input>
    </div>
</div>
