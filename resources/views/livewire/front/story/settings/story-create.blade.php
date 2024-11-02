<div class="my-6 px-3">
    <x-forms.label class="mb-2 text-base font-semibold">{{ __('Featured image') }}</x-forms.label>
    <p class="mb-2 text-xs text-gray-500">
        {{ __('Add a high-quality image to your story to keep your readers interested') }}
    </p>
    <div class="relative mt-2 w-full overflow-hidden">
        @include('livewire.front.story.settings.featured-image-create')
        @error('featuredImage')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
    {{-- Subtitle --}}
    <div class="mt-6">
        <x-forms.label class="mb-2 text-base font-semibold">{{ __('Subtitle') }}</x-forms.label>
        <x-forms.input
            wire:model='subTitle'
            placeholder="{{ __('You need subtitle?') }}"
            name="subTitle"
            type="text"></x-forms.input>
    </div>
    @if (auth()->user()->isAdmin())
        {{-- Users --}}
        <div class="mt-6">
            <x-forms.label class="mb-2 text-base font-semibold">{{ __('Author') }}</x-forms.label>
            <x-select
                wire:model="authorId"
                placeholder="{{ __('Select author') }}"
                :async-data="route('api.users.index')"
                class="shadow-none"
                :template="[
                    'username' => 'default',
                ]"
                option-label="username"
                option-value="id"
                option-description="name" />
        </div>
    @endif
    {{-- Community --}}
    <div class="mt-6">
        <x-forms.label class="mb-2 text-base font-semibold">{{ __('Community (optional)') }}</x-forms.label>
        <x-select
            wire:model="community"
            placeholder="{{ __('Select community') }}"
            :async-data="route('api.communities.index')"
            class="shadow-none"
            :template="[
                'name' => 'default',
            ]"
            option-label="name"
            option-value="id" />
    </div>
    {{-- Story content visibility --}}
    <div class="my-6">
        <x-forms.label class="mb-2 text-base font-semibold">{{ __('Story content visibility') }}</x-forms.label>
        <x-select
            searchable="0"
            clearable="0"
            placeholder="{{ __('Choose story content visibility') }}"
            class="shadow-none"
            wire:model="storyContentVisibility">
            <x-select.option label="{{ __('Everyone') }}" value="All" />
            <x-select.option label="{{ __('Only registered users') }}" value="Auth" />
        </x-select>
    </div>
    {{-- Tags --}}
    <div class="mt-6" wire:ignore wire:key="tagsData">
        <x-forms.label for="tagsData" class="text-base font-semibold">{{ __('Tags') }}
        </x-forms.label>
        <x-forms.input
            type="text"
            name="tagsData"
            id="tagsData"
            wire:model="tagsData"
            placeholder="{{ __('Add up 4 tags...') }}"></x-forms.input>
    </div>
</div>
