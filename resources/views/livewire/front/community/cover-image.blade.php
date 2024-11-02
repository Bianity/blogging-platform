<div>
    <div class="group relative">
        @if (auth()->id() === $community->user_id)
            <div
                class="absolute h-full w-full rounded-t-lg transition duration-500 ease-in-out group-hover:bg-black group-hover:bg-opacity-30">
            </div>
            <img class="h-64 max-h-64 w-full rounded-t-lg object-cover"
                src="{{ $community->getCoverImage() }}"
                alt="{{ $community->name }}{{ ' cover image' }}" />
        @else
            <img src="{{ $community->getCoverImage() }}"
                class="h-64 max-h-64 w-full rounded-t-lg object-cover"
                alt="{{ $community->name }}{{ ' cover image' }}" />
        @endif
        @if (auth()->id() === $community->user_id)
            <a href="#" onclick="$openModal('uploadCoverImage')"
                class="hidden group-hover:block"
                title="{{ __('Change cover image') }}">
                <div
                    class="absolute right-4 top-4 z-40 flex items-center rounded-xl bg-white bg-opacity-20 p-2 text-white">
                    <x-icons.user.camera
                        class="mr-2 h-7 w-7" />
                    {{ __('Change cover image') }}
                </div>
            </a>
        @endif
    </div>
    <x-modal blur wire:model="uploadCoverImage">
        @push('scripts')
            @vite(['resources/js/cropper.js'])
        @endpush
        <div class="w-full rounded-xl bg-white bg-opacity-20 shadow-2xl sm:max-w-5xl">
            <form wire:submit="changeCoverImage"
                class="border-1 z-10 rounded-xl border-gray-300 p-2">
                @if ($coverImage)
                    <div class="flex flex-col justify-center" wire:ignore x-data="{
                        setUpCropper() {
                            const minCroppedWidth = 1500;
                            const minCroppedHeight = 500;
                            const maxCroppedWidth = 2100;
                            const maxCroppedHeight = 700;
                    
                            const cropper = new Cropper(document.getElementById('cover-image'), {
                                viewMode: 3,
                                zoomable: true,
                                responsive: true,
                                center: true,
                                data: {
                                    width: (minCroppedWidth + maxCroppedWidth) / 2,
                                    height: (minCroppedHeight + maxCroppedHeight) / 2,
                                },
                    
                                crop(event) {
                                    let width = event.detail.width;
                                    let height = event.detail.height;
                                    if (
                                        width < minCroppedWidth ||
                                        height < minCroppedHeight ||
                                        width > maxCroppedWidth ||
                                        height > maxCroppedHeight
                                    ) {
                                        cropper.setData({
                                            width: Math.max(minCroppedWidth, Math.min(maxCroppedWidth, width)),
                                            height: Math.max(minCroppedHeight, Math.min(maxCroppedHeight, height)),
                                        });
                                    }
                                    @this.set('y', event.detail.y)
                                    @this.set('x', event.detail.x)
                                    @this.set('width', width)
                                    @this.set('height', height)
                                }
                            })
                        }
                    }"
                        x-init="setUpCropper">
                        <div class="mb-3">
                            <img id="cover-image" src="{{ $coverImage->temporaryUrl() }}" alt="cover image"
                                class="w-full rounded-xl">
                        </div>
                        <x-buttons.primary-button class="w-full" @click="close">Done</x-buttons.primary-button>
                    </div>
                @else
                    <label for="cover-image"
                        class="flex h-72 w-full cursor-pointer flex-col items-center justify-center space-y-2 rounded-xl bg-gray-100">
                        <x-icons.upload-file class="h-24 w-24 text-primary-500" />
                        <p class="text-lg text-primary-600">{{ __('Click and upload cover image') }}</p>
                    </label>
                    <input wire:model.live="coverImage" type="file" name="cover-image" id="cover-image" class="sr-only">
                @endif
            </form>
        </div>
    </x-modal>
</div>
