@if ($featuredImage)
    <div wire:key="img-1">
        <img src="{{ $featuredImage->temporaryUrl() }}" alt="Featured image"
            class="h-full max-h-60 w-full rounded-lg object-cover">
        <div
            wire:click="$set('featuredImage', '')"
            title="{{ __('Remove featured image') }}"
            class="absolute right-3 top-3 z-50 cursor-pointer rounded-md bg-red-500 bg-opacity-80 p-0.5 transition duration-200 ease-linear hover:rotate-90 hover:scale-110 hover:bg-red-600 hover:shadow-xl">
            <x-icons.close-square
                class="h-6 w-6 text-white" />
        </div>
    </div>
@elseif ($featuredImageMedia)
    <div wire:key="img-2">
        <img src="{{ $featuredImageMedia }}" alt="Featured image"
            class="h-full max-h-60 w-full rounded-lg object-cover">
        <div
            wire:click="deleteFeaturedImage"
            title="{{ __('Remove featured image') }}"
            class="absolute right-3 top-3 z-50 cursor-pointer rounded-md bg-red-500 bg-opacity-80 p-0.5 transition duration-200 ease-linear hover:rotate-90 hover:scale-110 hover:bg-red-600 hover:shadow-xl">
            <x-icons.close-square
                class="h-6 w-6 text-white" />
        </div>
    </div>
@else
    <div
        wire:key="img-3"
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">
        <div class="flex w-full items-center justify-center">
            <label x-show="!isUploading" for="featured_image"
                class="m-1 flex h-60 w-full cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-100 hover:border-primary-300 hover:bg-white hover:shadow">
                <div
                    class="flex flex-col items-center justify-center pb-6 pt-5">
                    <x-icons.gallery.image-add
                        class="mx-auto mb-3 h-14 w-14 text-gray-600" />
                    <p
                        class="mb-2 text-sm text-gray-500">
                        <span
                            class="font-semibold">{{ __('Add a featured image') }}</span>
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ __('PNG, JPG up to 5MB') }}</p>
                </div>
                <input wire:model="featuredImage" id="featured_image"
                    type="file"
                    class="hidden" accept="image/jpg, image/jpeg, image/png" />
            </label>
            <!-- Animate Upload -->
            <div x-show="isUploading"
                class="flex h-60 w-full items-center justify-center">
                <x-icons.is-uploading
                    class="inline h-16 w-16 animate-spin fill-primary-500 text-gray-200" />
                <span class="absolute text-lg text-primary-600" x-text="`${progress}%`"></span>
            </div>
        </div>
    </div>
@endif
