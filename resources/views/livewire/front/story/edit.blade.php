<div x-data="{ drawerOpen: false }">
    <div
        class="fixed inset-0 z-50 hidden h-screen overflow-y-auto bg-gray-900 bg-opacity-50 transition-opacity duration-200 dark:bg-slate-900 dark:bg-opacity-50 md:block"
        :class="drawerOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak></div>
    <form wire:submit="updateAndSave(Object.fromEntries(new FormData($event.target)))">
        @csrf
        <header
            class="sticky top-0 z-40 flex h-16 w-full items-center justify-between bg-primary_light px-2 transition-colors duration-500 sm:px-4 lg:overflow-y-auto">
            <div class="flex items-center">
                <a class="hidden h-16 max-w-[160px] shrink-0 sm:block" href="{{ route('home') }}">
                    @if ($generalSettings->site_logo !== '')
                        <img src="{{ Storage::disk(getCurrentDisk())->url($generalSettings->site_logo) }}"
                            class="h-full w-full object-contain"
                            alt="logo" />
                    @else
                        <img src="{{ asset('images/logo.svg') }}"
                            class="h-full w-full object-contain"
                            alt="logo" />
                    @endif
                </a>
                <div class="ml-0 sm:ml-6">
                    <div class="flex items-center">
                        <a href="{{ route('user.dashboard') }}"
                            class="z-20 inline-flex cursor-pointer items-center font-normal text-primary-500">
                            <x-icons.arrow-left class="mr-1 h-5 w-5" />
                            {{ __('All stories') }}
                        </a>
                        <div
                            class="mx-1 hidden h-5 w-0.5 rotate-12 transform border-l border-gray-500 sm:mx-2 sm:flex">
                        </div>
                        <a href="{{ route('story.show', $story) }}"
                            target="__black"
                            class="hidden h-full max-w-2xl items-center justify-center pr-2 text-gray-500 hover:text-primary-500 hover:underline sm:flex">
                            <p class="line-clamp-1">{{ $story->title }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex shrink-0 items-center">
                <x-buttons.default-button
                    type="submit"
                    wire:click="$set('submitted', false)"
                    id="saveButtonDraft"
                    onclick="saveButtonDraft"
                    class="mr-4">
                    {{ __('Save draft') }}
                </x-buttons.default-button>
                <x-buttons.primary-button
                    type="submit"
                    wire:click="$set('submitted', true)"
                    class="mr-4"
                    id="saveButtonPublish"
                    onclick="saveButtonPublish">
                    {{ isset($story->published_at) ? __('Update') : __('Publish') }}
                </x-buttons.primary-button>
                <x-buttons.default-button type="button" @click="drawerOpen = !drawerOpen">
                    <x-icons.user.settings class="h-6 w-6" />
                </x-buttons.default-button>
            </div>
        </header>
        <div class="relative mx-auto mt-8 flex max-w-3xl flex-col sm:mt-12">
            <section class="fixed inset-y-0 right-0 z-50 flex h-screen max-w-full">
                <div class="relative z-40 w-screen max-w-md" x-show="drawerOpen"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" x-cloak>
                    <div
                        class="flex h-full flex-col overflow-y-auto bg-white py-6 shadow-xl">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-semibold text-gray-700">
                                    {{ __('Settings') }}
                                </h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" @click="drawerOpen = false;"
                                        class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                        <span class="sr-only">Close panel</span>
                                        <x-icons.close-square class="h-7 w-7" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative mt-6 px-3">
                            <div class="space-y-3" x-data="{ activeAccordion: 0 }">
                                {{-- Story Settings --}}
                                <div>
                                    <h3>
                                        <button
                                            type="button"
                                            x-on:click="activeAccordion = activeAccordion === 0 ? false : 0"
                                            :class="{ 'bg-gray-200': activeAccordion === 0 }"
                                            class="flex w-full items-center justify-between rounded-lg py-4 text-lg font-bold hover:bg-gray-100">
                                            <span class="ml-3">{{ __('Story') }}</span>
                                        </button>
                                    </h3>
                                    <div x-cloak x-show="activeAccordion === 0" x-collapse>
                                        @include('livewire.front.story.settings.story-edit')
                                    </div>
                                </div>
                                {{-- SEO Settings --}}
                                <div>
                                    <h3>
                                        <button
                                            type="button"
                                            x-on:click="activeAccordion = activeAccordion === 1 ? false : 1"
                                            :class="{ 'bg-gray-200': activeAccordion === 1 }"
                                            class="flex w-full items-center justify-between rounded-lg py-4 text-lg font-bold hover:bg-gray-100">
                                            <span class="ml-3">{{ __('SEO') }}</span>
                                        </button>
                                    </h3>
                                    <div x-cloak x-show="activeAccordion === 1" x-collapse>
                                        @include('livewire.front.story.settings.seo')
                                    </div>
                                </div>
                                {{-- Audio File Settings --}}
                                <div>
                                    <h3>
                                        <button
                                            type="button"
                                            x-on:click="activeAccordion = activeAccordion === 2 ? false : 2"
                                            :class="{ 'bg-gray-200': activeAccordion === 2 }"
                                            class="flex w-full items-center justify-between rounded-lg py-4 text-lg font-bold hover:bg-gray-100">
                                            <span class="ml-3">{{ __('Audio') }}</span>
                                        </button>
                                    </h3>
                                    <div x-cloak x-show="activeAccordion === 2" x-collapse>
                                        @include('livewire.front.story.settings.audio-file-edit')
                                        @error('audioFile')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Comments Settings --}}
                                <div>
                                    <h3>
                                        <button
                                            type="button"
                                            x-on:click="activeAccordion = activeAccordion === 3 ? false : 3"
                                            :class="{ 'bg-gray-200': activeAccordion === 3 }"
                                            class="flex w-full items-center justify-between rounded-lg py-4 text-lg font-bold hover:bg-gray-100">
                                            <span class="ml-3">{{ __('Comments') }}</span>
                                        </button>
                                    </h3>
                                    <div x-cloak x-show="activeAccordion === 3" x-collapse>
                                        @include('livewire.front.story.settings.comments')
                                    </div>
                                </div>
                                {{-- Poll --}}
                                <div>
                                    <h3>
                                        <button
                                            type="button"
                                            x-on:click="activeAccordion = activeAccordion === 4 ? false : 4"
                                            :class="{ 'bg-gray-200': activeAccordion === 4 }"
                                            class="flex w-full items-center justify-between rounded-lg py-4 text-lg font-bold hover:bg-gray-100">
                                            <span class="ml-3">{{ __('Poll') }}</span>
                                        </button>
                                    </h3>
                                    <div x-cloak x-show="activeAccordion === 4" x-collapse>
                                        @include('livewire.front.story.settings.poll')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grow px-3 sm:px-0.5">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <x-forms.textarea-constrained
                    wire:model='title'
                    wire:ignore
                    @keydown.enter.prevent="$event.target.focus()"
                    x-data="{
                        resize: () => {
                            $el.style.height = '20px';
                            $el.style.height = $el.scrollHeight + 'px'
                        }
                    }"
                    x-init="resize"
                    x-on:input="resize"
                    limit="160"
                    :value="$story->title"
                    type="text"
                    class="textarea-ghost my-4 text-2xl font-bold sm:text-3xl lg:text-4xl" />
                <div wire:key="editor" wire:ignore id="editorjs"></div>
            </section>
        </div>
    </form>
    <livewire:front.poll.form :story="$story" />
</div>

@push('editor-scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            var input = document.getElementById('tagsData'),
                tagify = new Tagify(input, {
                    whitelist: [],
                    pattern: /^(?!#).*$/,
                    maxTags: 4,
                    maxItems: 4,
                    blacklist: ["foo", "bar", "porn", "#"],
                    backspace: "edit",
                    placeholder: "{{ __('Add up 4 tags...') }}",
                }),
                controller; // for aborting the call

            // listen to any keystrokes which modify tagify's input
            tagify.on('input', onInput)

            var delayTimer;

            function onInput(e) {
                var value = e.detail.value
                tagify.whitelist = null // reset the whitelist

                controller && controller.abort()
                controller = new AbortController()

                // show loading animation and hide the suggestions dropdown
                if (value !== '#' && value !== '') {
                    tagify.loading(true).dropdown.hide()
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(function() {
                        fetch('{{ route('api.tags.whitelist') }}?value=' + value, {
                                signal: controller.signal
                            })
                            .then(RES => RES.json())
                            .then(function(newWhitelist) {
                                tagify.whitelist = newWhitelist // update whitelist Array in-place
                                tagify.loading(false).dropdown.show(
                                    value) // render the suggestions dropdown
                            })
                            .catch((err) => {
                                console.log(err);
                                console.log(value);
                                err => tagify.dropdown.hide()
                            });
                    }, 300);
                }
            }
        });
    </script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            var input = document.getElementById('metaKeywords'),
                tagify = new Tagify(input, {
                    whitelist: [],
                    pattern: /^(?!#).*$/,
                    maxTags: 4,
                    maxItems: 4,
                    blacklist: ["foo", "bar", "porn", "#"],
                    backspace: "edit",
                    placeholder: "{{ __('Add up 10 keywords...') }}",
                }),
                controller; // for aborting the call

            // listen to any keystrokes which modify tagify's input
            tagify.on('input', onInput)

            var delayTimer;

            function onInput(e) {
                var value = e.detail.value
                tagify.whitelist = null // reset the whitelist

                controller && controller.abort()
                controller = new AbortController()

                // show loading animation and hide the suggestions dropdown
                if (value !== '#' && value !== '') {
                    tagify.loading(true).dropdown.hide()
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(function() {
                        fetch('{{ route('api.tags.whitelist') }}?value=' + value, {
                                signal: controller.signal
                            })
                            .then(RES => RES.json())
                            .then(function(newWhitelist) {
                                tagify.whitelist = newWhitelist // update whitelist Array in-place
                                tagify.loading(false).dropdown.show(
                                    value) // render the suggestions dropdown
                            })
                            .catch((err) => {
                                console.log(err);
                                console.log(value);
                                err => tagify.dropdown.hide()
                            });
                    }, 300);
                }
            }
        });
    </script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            const dataSaved = @this.get('editorData');
            const editor = new EditorJS({
                data: dataSaved,

                holder: 'editorjs',
                placeholder: '{{ __('Write something wonderful...') }}',
                tools: {
                    header: {
                        class: Header,
                        config: {
                            placeholder: 'Enter a header',
                            levels: [2, 3, 4],
                            defaultLevel: 2
                        }
                    },
                    image: {
                        class: ImageTool,

                        config: {
                            field: 'image',
                            type: 'image/*',
                            uploader: {
                                uploadByFile: (file) => {
                                    return new Promise((resolve) => {
                                        @this.upload(
                                            'uploads',
                                            file,
                                            (uploadedFilename) => {
                                                const eventName =
                                                    `fileupload:${uploadedFilename.substr(0, 20)}`;

                                                const storeListener = (event) => {
                                                    resolve({
                                                        success: 1,
                                                        file: {
                                                            url: event.detail[0]
                                                                .url
                                                        }
                                                    });

                                                    window.removeEventListener(
                                                        eventName, storeListener);
                                                };

                                                window.addEventListener(eventName,
                                                    storeListener);

                                                @this.call('completedImageUpload',
                                                    uploadedFilename, eventName);
                                            }
                                        );
                                    });
                                },

                                uploadByUrl: (url) => {
                                    return @this.loadImageFromUrl(url).then(result => {
                                        return {
                                            success: 1,
                                            file: {
                                                url: result
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    },
                    paragraph: {
                        class: Paragraph,
                        inlineToolbar: true,
                    },
                    embed: {
                        class: Embed,
                        inlineToolbar: true,
                        config: {
                            services: {
                                youtube: true,
                                twitter: true,
                                vimeo: true,
                                facebook: true,
                                instagram: true,
                                gfycat: true,
                                coub: true
                            }
                        }
                    },
                    list: List,
                    quote: {
                        class: Quote,
                        inlineToolbar: true,
                        shortcut: 'CMD+SHIFT+O',
                        config: {
                            quotePlaceholder: 'Enter a quote',
                            captionPlaceholder: 'Quote\'s author',
                        },
                    },
                    inlineCode: {
                        class: InlineCode,
                        shortcut: 'CMD+SHIFT+M',
                    },
                    Marker: {
                        class: Marker,
                        shortcut: 'CMD+SHIFT+M',
                    },
                    delimiter: Delimiter,
                    underline: Underline,
                },
                onChange: function() {
                    console.log('something changed');
                }
            });

            saveButtonDraft.addEventListener('click', function(e) {
                editor.save().then((outputData) => {
                    @this.set('savedData', outputData)
                });
            });

            saveButtonPublish.addEventListener('click', function(e) {
                editor.save().then((outputData) => {
                    @this.set('savedData', outputData)
                });
            });
        });
    </script>
@endpush
