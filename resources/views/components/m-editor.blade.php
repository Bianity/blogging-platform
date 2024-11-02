@props([
'id' => 'editor-'. str()->random(8),
'height' => '400px',
'label' => null,
'name' => null,
'value' => null,
'noMargin' => false,
'readonly' => false,
'disabled' => false,
'toolbar' => true
])

<div class="{{ $noMargin ? 'mb-0' : 'mb-5' }}">
    @if($label)
        <label class="block font-medium text-sm text-gray-800 mb-1">
            {{ $label }}
        </label>
    @endif
    <div x-data="{
	height: '{{ $height }}',
	tab: 'write',
	@if ($attributes->has('wire:model.live'))
            content: @entangle($attributes->wire('model')).live,
@else
            content: {{ collect($value) }},
	@endif
            showConvertedMarkdown: false,
            convertedContent: '',
            convertedMarkdown() {
             this.showConvertedMarkdown = true;
             this.convertedContent = marked.parse(DOMPurify.sanitize(this.content));
            },
            replaceSelectedText(replacementText, newCharactersLength) {
                // 1. obtain the object reference for the textarea
                const textareaRef = this.$refs.input;
                // 2. obtain the index of the first selected character
                let start = textareaRef.selectionStart;
                // 3. obtain the index of the last selected character
                let finish = textareaRef.selectionEnd;
                // 4. obtain all the text content
                const allText = textareaRef.value;
                // 5. Bind 'allText' to the 'content' data object
                this.content = allText.substring(0, start) + replacementText + allText.substring(finish, allText.length);
                // 6. Put the cursor to the end of selected text
                this.$nextTick(() => this.setCursorPosition(this.$refs.input, finish + newCharactersLength));
            },
            setCursorPosition(el, pos) {
             el.focus();
             el.setSelectionRange(pos, pos);
            },
            toggleMenu(value) {
                let selectedString = document.getSelection();
                let linkText = selectedString.toString().startsWith('http') ? selectedString : 'Your link';
                switch (value) {
                    case 'bold':
                    this.replaceSelectedText(`**${selectedString}**`, 4);
                    break;
                    case 'italic':
                    this.replaceSelectedText(`*${selectedString}*`, 2);
                    break;
                    case 'quote':
                    this.replaceSelectedText(`> ${selectedString}`, 2);
                    break;
                    case 'link':
                    this.replaceSelectedText(`[${selectedString}](${linkText})`, 4);
                    break;
                    case 'image':
                    this.replaceSelectedText(`![image alt text](${linkText})`, 5);
                    break;
                    case 'fullscreen':
                    this.$refs.input.classList.add('fullscreen');
                    break;
                }
            },
            removeFullscreen() {
                if ( this.$refs.input.classList.contains('fullscreen')) {
                    this.$refs.input.classList.remove('fullscreen');
                }
            }
            }"
         x-on:keyup.escape.window="removeFullscreen()"
         class="relative" x-cloak wire:ignore>

        <div class="flex items-center bg-gray-50 border border-b-0 border-gray-300 block rounded-t-md text-gray-400 pr-4">
            <div class="flex-1">
                <button type="button" class="py-2 px-4 inline-block font-semibold"
                        :class="{ 'text-indigo-600': tab === 'write' }"
                        x-on:click.prevent="tab = 'write'; showConvertedMarkdown = false">Write
                </button>
                <button type="button" class="py-2 px-4 inline-block font-semibold"
                        :class="{ 'text-indigo-600': tab === 'preview' && showConvertedMarkdown === true }"
                        x-on:click.prevent="tab = 'preview'; convertedMarkdown()">Preview
                </button>
            </div>
            @if ($toolbar)
                <button x-tooltip="'bold'" type="button" class="py-2 px-2 inline-block group"
                        x-on:click.prevent="toggleMenu('bold')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0009 12.75H4.88086C4.47086 12.75 4.13086 12.41 4.13086 12V4.5C4.13086 2.98 5.36086 1.75 6.88086 1.75H12.0009C15.0309 1.75 17.5009 4.22 17.5009 7.25C17.5009 10.28 15.0309 12.75 12.0009 12.75ZM5.62086 11.25H12.0009C14.2109 11.25 16.0009 9.46 16.0009 7.25C16.0009 5.04 14.2109 3.25 12.0009 3.25H6.88086C6.19086 3.25 5.63086 3.81 5.63086 4.5V11.25H5.62086Z"
                              fill="currentColor"/>
                        <path d="M14.3809 22.25H6.88086C5.36086 22.25 4.13086 21.02 4.13086 19.5V12C4.13086 11.59 4.47086 11.25 4.88086 11.25H14.3809C17.4109 11.25 19.8809 13.72 19.8809 16.75C19.8809 19.78 17.4109 22.25 14.3809 22.25ZM5.62086 12.75V19.5C5.62086 20.19 6.18086 20.75 6.87086 20.75H14.3709C16.5809 20.75 18.3709 18.96 18.3709 16.75C18.3709 14.54 16.5809 12.75 14.3709 12.75H5.62086Z"
                              fill="currentColor"/>
                    </svg>
                </button>
                <button x-tooltip="'italic'" type="button" class="py-2 px-2 inline-block group"
                        x-on:click.prevent="toggleMenu('italic')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.8809 3.75H9.62086C9.21086 3.75 8.88086 3.41 8.88086 3C8.88086 2.59 9.22086 2.25 9.63086 2.25H18.8809C19.2909 2.25 19.6309 2.59 19.6309 3C19.6309 3.41 19.2909 3.75 18.8809 3.75Z"
                              fill="currentColor"/>
                        <path d="M14.3791 21.75H5.11914C4.70914 21.75 4.36914 21.41 4.36914 21C4.36914 20.59 4.70914 20.25 5.11914 20.25H14.3691C14.7791 20.25 15.1191 20.59 15.1191 21C15.1191 21.41 14.7891 21.75 14.3791 21.75Z"
                              fill="currentColor"/>
                        <path d="M9.7501 21.7501C9.6901 21.7501 9.6301 21.7401 9.5701 21.7301C9.1701 21.6301 8.9201 21.2201 9.0201 20.8201L13.5201 2.8201C13.6201 2.4201 14.0201 2.1701 14.4301 2.2701C14.8301 2.3701 15.0801 2.7801 14.9801 3.1801L10.4801 21.1801C10.3901 21.5201 10.0901 21.7501 9.7501 21.7501Z"
                              fill="currentColor"/>
                    </svg>
                </button>

                <button x-tooltip="'quote'" type="button" class="py-2 px-2 inline-block group"
                        x-on:click.prevent="toggleMenu('quote')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.79999 21.4698H4.58002C2.75002 21.4698 1.25 19.9798 1.25 18.1398V12.3398C1.25 11.9298 1.59 11.5898 2 11.5898H7.79999C9.69999 11.5898 11.13 13.0198 11.13 14.9198V18.1398C11.12 20.0398 9.68999 21.4698 7.79999 21.4698ZM2.75 13.0998V18.1498C2.75 19.1598 3.57002 19.9798 4.58002 19.9798H7.79999C8.85999 19.9798 9.63 19.2098 9.63 18.1498V14.9298C9.63 13.8698 8.85999 13.0998 7.79999 13.0998H2.75Z"
                              fill="currentColor"/>
                        <path d="M2 13.0998C1.59 13.0998 1.25 12.7598 1.25 12.3498C1.25 6.0998 2.52002 4.78984 6.15002 2.63984C6.51002 2.42984 6.96999 2.54985 7.17999 2.89985C7.38999 3.25985 7.26998 3.71982 6.91998 3.92982C3.67998 5.84981 2.75 6.6498 2.75 12.3498C2.75 12.7598 2.41 13.0998 2 13.0998Z"
                              fill="currentColor"/>
                        <path d="M19.4211 21.4698H16.2011C14.3711 21.4698 12.8711 19.9798 12.8711 18.1398V12.3398C12.8711 11.9298 13.2111 11.5898 13.6211 11.5898H19.4211C21.3211 11.5898 22.7511 13.0198 22.7511 14.9198V18.1398C22.7511 20.0398 21.3211 21.4698 19.4211 21.4698ZM14.3811 13.0998V18.1498C14.3811 19.1598 15.2011 19.9798 16.2111 19.9798H19.4311C20.4911 19.9798 21.2611 19.2098 21.2611 18.1498V14.9298C21.2611 13.8698 20.4911 13.0998 19.4311 13.0998H14.3811Z"
                              fill="currentColor"/>
                        <path d="M13.6289 13.0998C13.2189 13.0998 12.8789 12.7598 12.8789 12.3498C12.8789 6.0998 14.1489 4.78984 17.7789 2.63984C18.1389 2.42984 18.5989 2.54985 18.8089 2.89985C19.0189 3.25985 18.8989 3.71982 18.5489 3.92982C15.3089 5.84981 14.3789 6.6498 14.3789 12.3498C14.3789 12.7598 14.0389 13.0998 13.6289 13.0998Z"
                              fill="currentColor"/>
                    </svg>
                </button>
                <button x-tooltip="'link'" type="button" class="py-2 px-2 inline-block group"
                        x-on:click.prevent="toggleMenu('link')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.98969 21.5001C7.32969 21.5001 5.65969 20.8701 4.38969 19.6001C1.85969 17.0601 1.85969 12.9401 4.38969 10.4101C4.67969 10.1201 5.15969 10.1201 5.44969 10.4101C5.73969 10.7001 5.73969 11.1801 5.44969 11.4701C3.49969 13.4201 3.49969 16.5901 5.44969 18.5401C7.39969 20.4901 10.5697 20.4901 12.5197 18.5401C13.4597 17.6001 13.9797 16.3401 13.9797 15.0001C13.9797 13.6701 13.4597 12.4101 12.5197 11.4601C12.2297 11.1701 12.2297 10.6901 12.5197 10.4001C12.8097 10.1101 13.2897 10.1101 13.5797 10.4001C14.8097 11.6301 15.4797 13.2601 15.4797 15.0001C15.4797 16.7401 14.7997 18.3701 13.5797 19.6001C12.3197 20.8701 10.6597 21.5001 8.98969 21.5001Z"
                              fill="currentColor"/>
                        <path d="M19.0701 14.1602C18.8801 14.1602 18.6901 14.0902 18.5401 13.9402C18.2501 13.6502 18.2501 13.1702 18.5401 12.8802C20.5901 10.8302 20.5901 7.50023 18.5401 5.46023C16.4901 3.41023 13.1601 3.41023 11.1201 5.46023C10.1301 6.45023 9.58008 7.77023 9.58008 9.17023C9.58008 10.5702 10.1301 11.8902 11.1201 12.8802C11.4101 13.1702 11.4101 13.6502 11.1201 13.9402C10.8301 14.2302 10.3501 14.2302 10.0601 13.9402C8.79008 12.6702 8.08008 10.9702 8.08008 9.17023C8.08008 7.37023 8.78008 5.67023 10.0601 4.40023C12.6901 1.77023 16.9701 1.77023 19.6101 4.40023C22.2401 7.03023 22.2401 11.3202 19.6101 13.9502C19.4601 14.0902 19.2601 14.1602 19.0701 14.1602Z"
                              fill="currentColor"/>
                    </svg>
                </button>
                <button x-tooltip="'image'" type="button" class="py-2 px-2 inline-block group"
                        x-on:click.prevent="toggleMenu('image')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 22.75H9C3.57 22.75 1.25 20.43 1.25 15V9C1.25 3.57 3.57 1.25 9 1.25H15C20.43 1.25 22.75 3.57 22.75 9V15C22.75 20.43 20.43 22.75 15 22.75ZM9 2.75C4.39 2.75 2.75 4.39 2.75 9V15C2.75 19.61 4.39 21.25 9 21.25H15C19.61 21.25 21.25 19.61 21.25 15V9C21.25 4.39 19.61 2.75 15 2.75H9Z"
                              fill="currentColor"/>
                        <path d="M9 10.75C7.48 10.75 6.25 9.52 6.25 8C6.25 6.48 7.48 5.25 9 5.25C10.52 5.25 11.75 6.48 11.75 8C11.75 9.52 10.52 10.75 9 10.75ZM9 6.75C8.31 6.75 7.75 7.31 7.75 8C7.75 8.69 8.31 9.25 9 9.25C9.69 9.25 10.25 8.69 10.25 8C10.25 7.31 9.69 6.75 9 6.75Z"
                              fill="currentColor"/>
                        <path d="M2.67075 19.7001C2.43075 19.7001 2.19075 19.5801 2.05075 19.3701C1.82075 19.0301 1.91075 18.5601 2.26075 18.3301L7.19075 15.0201C8.27075 14.2901 9.76075 14.3801 10.7407 15.2101L11.0707 15.5001C11.5707 15.9301 12.4207 15.9301 12.9107 15.5001L17.0707 11.9301C18.1307 11.0201 19.8007 11.0201 20.8707 11.9301L22.5007 13.3301C22.8107 13.6001 22.8507 14.0701 22.5807 14.3901C22.3107 14.7001 21.8407 14.7401 21.5207 14.4701L19.8907 13.0701C19.3907 12.6401 18.5407 12.6401 18.0407 13.0701L13.8807 16.6401C12.8207 17.5501 11.1507 17.5501 10.0807 16.6401L9.75075 16.3501C9.29075 15.9601 8.53075 15.9201 8.02075 16.2701L3.09075 19.5801C2.96075 19.6601 2.81075 19.7001 2.67075 19.7001Z"
                              fill="currentColor"/>
                    </svg>
                </button>
                <button x-tooltip="'fullscreen'" type="button" class="py-2 px-2 inline-block group"
                        x-on:click.prevent="toggleMenu('fullscreen')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 9.75C1.59 9.75 1.25 9.41 1.25 9V6.5C1.25 3.61 3.61 1.25 6.5 1.25H9C9.41 1.25 9.75 1.59 9.75 2C9.75 2.41 9.41 2.75 9 2.75H6.5C4.43 2.75 2.75 4.43 2.75 6.5V9C2.75 9.41 2.41 9.75 2 9.75Z"
                              fill="currentColor"/>
                        <path d="M22 9.75C21.59 9.75 21.25 9.41 21.25 9V6.5C21.25 4.43 19.57 2.75 17.5 2.75H15C14.59 2.75 14.25 2.41 14.25 2C14.25 1.59 14.59 1.25 15 1.25H17.5C20.39 1.25 22.75 3.61 22.75 6.5V9C22.75 9.41 22.41 9.75 22 9.75Z"
                              fill="currentColor"/>
                        <path d="M17.5 22.75H16C15.59 22.75 15.25 22.41 15.25 22C15.25 21.59 15.59 21.25 16 21.25H17.5C19.57 21.25 21.25 19.57 21.25 17.5V16C21.25 15.59 21.59 15.25 22 15.25C22.41 15.25 22.75 15.59 22.75 16V17.5C22.75 20.39 20.39 22.75 17.5 22.75Z"
                              fill="currentColor"/>
                        <path d="M9 22.75H6.5C3.61 22.75 1.25 20.39 1.25 17.5V15C1.25 14.59 1.59 14.25 2 14.25C2.41 14.25 2.75 14.59 2.75 15V17.5C2.75 19.57 4.43 21.25 6.5 21.25H9C9.41 21.25 9.75 21.59 9.75 22C9.75 22.41 9.41 22.75 9 22.75Z"
                              fill="currentColor"/>
                    </svg>
                </button>
            @endif

            <div class="relative" x-data="{ open: false }" x-on:click.away="open = false"
                 x-on:close.stop="open = false">
                <button x-tooltip="'Markdown Cheatsheet'" type="button"
                        class="rounded-lg py-2 px-2 inline-block group focus:ring-1 focus:ring-indigo-200"
                        x-on:click="open = ! open">
                    <svg class="h-5 w-5 transform rotate-180 text-gray-500 group-hover:text-indigo-600"
                         viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22.75C6.07 22.75 1.25 17.93 1.25 12C1.25 6.07 6.07 1.25 12 1.25C17.93 1.25 22.75 6.07 22.75 12C22.75 17.93 17.93 22.75 12 22.75ZM12 2.75C6.9 2.75 2.75 6.9 2.75 12C2.75 17.1 6.9 21.25 12 21.25C17.1 21.25 21.25 17.1 21.25 12C21.25 6.9 17.1 2.75 12 2.75Z"
                              fill="currentColor"/>
                        <path d="M12 13.75C11.59 13.75 11.25 13.41 11.25 13V8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V13C12.75 13.41 12.41 13.75 12 13.75Z"
                              fill="currentColor"/>
                        <path d="M12 16.9999C11.87 16.9999 11.74 16.9699 11.62 16.9199C11.5 16.8699 11.39 16.7999 11.29 16.7099C11.2 16.6099 11.13 16.5099 11.08 16.3799C11.03 16.2599 11 16.1299 11 15.9999C11 15.8699 11.03 15.7399 11.08 15.6199C11.13 15.4999 11.2 15.3899 11.29 15.2899C11.39 15.1999 11.5 15.1299 11.62 15.0799C11.86 14.9799 12.14 14.9799 12.38 15.0799C12.5 15.1299 12.61 15.1999 12.71 15.2899C12.8 15.3899 12.87 15.4999 12.92 15.6199C12.97 15.7399 13 15.8699 13 15.9999C13 16.1299 12.97 16.2599 12.92 16.3799C12.87 16.5099 12.8 16.6099 12.71 16.7099C12.61 16.7999 12.5 16.8699 12.38 16.9199C12.26 16.9699 12.13 16.9999 12 16.9999Z"
                              fill="currentColor"/>
                    </svg>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute z-50 mt-2 w-80 rounded-md shadow-lg origin-top-right right-0 -mr-5"
                     style="display: none;"
                     x-on:click="open = false">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5 p-4 bg-white text-sm">
                        <div class="px-2 py-1 text-xs font-medium uppercase tracking-wider bg-gray-50 border border-gray-100 mb-2 text-center rounded text-gray-600">
                            Markdown Notes
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Heading</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">## Heading H2</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Bold</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">**bold text**</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Italic</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">*italicized text*</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Blockquote</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">> blockquote</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Ordered List</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">
                                1. First <br>
                                2. Second
                            </div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Unordered List</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">
                                - First <br>
                                - Second
                            </div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Horizontal Rule</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">---</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Link</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">[title](url)</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Image</div>
                            <div class="text-gray-800 flex-1 font-mono text-xs mt-1">![alt](image.jpg)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <textarea spellcheck="false" x-show="! showConvertedMarkdown" id="{{ $id }}" x-ref="input" x-model="content"
                  name="{{ $name }}"
                  class="overflow-y-auto form-textarea bg-white relative transition duration-150 ease-in-out block w-full font-mono text-sm text-gray-700 border border-gray-300 bg-white px-5 py-6 resize-none rounded-b-md focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                  :style="`height: ${height}; max-width: 100%`"></textarea>

        <div x-show="showConvertedMarkdown">
            <div x-html="convertedContent"
                 class="w-full prose max-w-none prose-indigo leading-6 rounded-b-md shadow-sm border border-gray-300 p-5 bg-white overflow-y-auto"
                 :style="`height: ${height}; max-width: 100%`"></div>
        </div>
    </div>

    @error($name)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>


<style>
    .fullscreen {
        width: 100vw !important;
        height: 100vh !important;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1001;
        overflow-y: auto;
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/marked@4.0.12/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dompurify@2.3.6/dist/purify.min.js"></script>

