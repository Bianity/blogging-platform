<div>
    <div class="group relative">
        @if (auth()->id() === $community->user_id)
            <div
                class="absolute z-20 h-full w-full rounded-full transition duration-500 ease-in-out group-hover:bg-black group-hover:bg-opacity-30">
            </div>
            <img src="{{ $community->getAvatar() }}" title="Community Avatar"
                class="h-[128px] rounded-full border-2 border-primary-100 object-cover shadow-xl dark:border-primary-900 sm:h-32 sm:w-32"
                alt="{{ $community->name }}" />
        @else
            <img src="{{ $community->getAvatar() }}" title="Community Avatar"
                class="h-[128px] rounded-full border-2 border-primary-100 object-cover shadow-xl dark:border-primary-900 sm:h-32 sm:w-32"
                alt="{{ $community->name }}" />
        @endif

        @if (auth()->id() === $community->user_id)
            <a href="#" onclick="$openModal('uploadAvatar')"
                class="relative hidden group-hover:block" title="{{ __('Change avatar') }}">
                <div class="absolute bottom-[36px] left-[36px] z-40 rounded-full bg-white bg-opacity-10 p-3">
                    <x-icons.user.camera class="h-8 w-8 text-white" />
                </div>
            </a>
        @endif
    </div>
    <x-modal blur wire:model="uploadAvatar">
        @push('scripts')
            @vite(['resources/js/cropper.js'])
        @endpush
        <div class="w-full rounded-xl bg-white bg-opacity-20 shadow-2xl sm:max-w-xl">
            <form wire:submit="changeAvatar"
                class="border-1 z-10 rounded-xl border-gray-300 p-2">
                @if ($avatar)
                    <div class="flex flex-col justify-center" wire:ignore x-data="{
                        setUp() {
                            const cropper = new Cropper(document.getElementById('avatar'), {
                                aspectRatio: 1 / 1,
                                autoCropArea: 1,
                                viewMode: 1,
                                crop(event) {
                                    @this.set('y', event.detail.y)
                                    @this.set('x', event.detail.x)
                                    @this.set('width', event.detail.width)
                                    @this.set('height', event.detail.height)
                                }
                            })
                        }
                    }"
                        x-init="setUp">
                        <div class="mb-3">
                            <img id="avatar" src="{{ $avatar->temporaryUrl() }}" alt=""
                                class="w-full rounded-xl">
                        </div>
                        <x-buttons.primary-button class="w-full" @click="close">Done</x-buttons.primary-button>
                    </div>
                @else
                    <label for="avatar"
                        class="flex h-72 w-full cursor-pointer flex-col items-center justify-center space-y-2 rounded-xl bg-gray-100">
                        <x-icons.upload-file class="h-24 w-24 text-primary-500" />
                        <p class="text-lg text-primary-600">{{ __('Click and upload avatar') }}</p>
                    </label>
                    <input wire:model.live="avatar" type="file" name="avatar" id="avatar" class="sr-only">
                @endif
            </form>
        </div>
    </x-modal>
</div>
