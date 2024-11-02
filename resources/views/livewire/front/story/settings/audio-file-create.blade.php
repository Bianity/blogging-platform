@if ($audioFile)
    <div class="my-6 flex items-center justify-between px-2" wire:key="audio-1">
        <audio controls>
            <source src="{{ $audioFile->temporaryUrl() }}" alt="audio">
            {{ __('Your browser does not support the audio tag.') }}
        </audio>
        <div
            wire:click="$set('audioFile', '')"
            class="cursor-pointer p-0.5 transition duration-200 ease-linear hover:text-negative-500 hover:underline">
            {{ __('Remove') }}
        </div>
    </div>
@else
    <div
        wire:key="audio-2"
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">
        <div class="my-6 flex w-full items-center justify-center">
            <label x-show="!isUploading" for="audio_file"
                class="flex w-full cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-100 hover:border-primary-300 hover:bg-white hover:shadow">
                <div
                    class="flex flex-col items-center justify-center p-5">
                    <x-icons.gallery.audio
                        class="mx-auto mb-3 h-14 w-14 text-gray-600" />
                    <p
                        class="mb-2 text-center text-xs text-gray-500">
                        <span class="font-semibold">
                            {{ __('Add an audio file that will be displayed at the top of your story (e.g., podcast)') }}
                        </span>
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ __('MP3, up to 500MB') }}</p>
                </div>
                <input wire:model="audioFile" id="audio_file"
                    type="file"
                    class="hidden" accept=".mp3" />
            </label>
            <!-- Animate Upload -->
            <div x-show="isUploading"
                class="flex h-40 w-full items-center justify-center">
                <x-icons.is-uploading
                    class="inline h-16 w-16 animate-spin fill-primary-500 text-gray-200" />
                <span class="absolute text-lg text-primary-600" x-text="`${progress}%`"></span>
            </div>
        </div>
    </div>
@endif
