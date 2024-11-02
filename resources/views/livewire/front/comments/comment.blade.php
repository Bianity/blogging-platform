<div>
    <div class="flex items-center justify-between pt-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('user.show', ['user' => $comment->user]) }}">
                <x-users.avatar-circle-comment :user="$comment->user" />
            </a>
            <div class="ml-4 flex-col">
                <a href="{{ route('user.show', ['user' => $comment->user]) }}"
                    class="text-base font-semibold hover:text-primary-500 dark:text-slate-200">
                    {{ $comment->user->name }}
                </a>
                <div class="text-xs text-gray-500 dark:text-slate-400">
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                    @if ($comment->user->id == $story->author->id)
                        <span class="ml-0.5 text-primary-600">Author</span>
                    @endif
                </div>
            </div>
            {{-- Save --}}
            @if (auth()->id() !== $comment->user->id)
                <livewire:front.favorite :model="$comment" wire:key="{{ $comment->id }}" />
            @endif
        </div>
        <div x-data="{ isOpen: false }" class="mt-4 flex items-center space-x-2 md:mt-0">
            @auth
                <div class="relative">
                    <button @click="isOpen = !isOpen"
                        class="relative h-6 rounded-full px-2">
                        <x-icons.three-dots-horizontal />
                    </button>
                    <ul x-cloak x-show="isOpen" x-transition.duration.300ms @click.away="isOpen = false"
                        @keydown.escape.window="isOpen = false"
                        class="absolute right-0 top-8 z-10 w-44 rounded-xl bg-white p-1 text-sm font-medium shadow-dialog dark:bg-slate-900 dark:text-slate-200 md:top-6">
                        @if (auth()->id() !== $comment->user->id)
                            <li wire:ignore>
                                <livewire:front.report-comment :comment="$comment" wire:key="report-comment" />
                            </li>
                        @endif
                        @can('update', $comment)
                            <li>
                                <button type="button"
                                    @click.prevent="isOpen = false"
                                    wire:click="$toggle('isEditing')"
                                    class="hover:shadow-xs block w-full rounded px-5 py-2 text-left transition duration-100 ease-in hover:bg-slate-100 dark:hover:bg-slate-700">
                                    {{ __('Edit') }}
                                </button>
                            </li>
                        @endcan
                        @can('delete', $comment)
                            <li>
                                <button type="button"
                                    class="hover:shadow-xs block w-full rounded px-5 py-2 text-left text-red-600 transition duration-100 ease-in hover:bg-red-50 dark:text-red-300 dark:hover:bg-red-800 dark:hover:bg-opacity-40 dark:hover:text-white"
                                    x-on:confirm="{
                                        title: '{{ __('Delete? Are you sure?') }}',
                                        description: '{{ __('This will erase your comment.') }}',
                                        icon: 'error',
                                        iconColor: 'text-red-500',
                                        iconBackground: 'bg-transparent',
                                        accept: {
                                            label: '{{ __('Delete') }}',
                                            method: 'deleteComment',
                                            params: {{ $comment->id }}
                                        },
                                        params: 1
                                    }">
                                    {{ __('Delete') }}
                                </button>
                            </li>
                        @endcan
                    </ul>
                </div>
            @endauth
        </div>
    </div>

    {{-- Comment --}}
    @if ($isEditing)
        <div
            wire:target="cancelIsEditing"
            class="@error('editState.comment') border-red-500 @enderror my-2 rounded-md border border-gray-200 bg-white p-4 hover:border-primary-500/20 hover:shadow-sm focus:border-primary-500/20 focus:ring-primary-500/20 dark:border-slate-50/[0.06] dark:bg-slate-800">
            <form wire:submit="editComment">
                <div>
                    <label for="comment" class="sr-only">{{ __('Comment body') }}</label>
                    <textarea wire:model="editState.comment"
                        x-data="{
                            resize: () => {
                                $el.style.height = '40px';
                                $el.style.height = $el.scrollHeight + 'px'
                            }
                        }"
                        x-init="resize"
                        x-on:input="resize"
                        id="comment"
                        name="comment"
                        class="mb-4 block w-full overflow-hidden border-transparent p-0 focus:border-transparent focus:outline-none focus:ring-0 dark:bg-slate-800 dark:text-slate-200 sm:mb-8"
                        placeholder="Write something">
                    </textarea>
                    @if ($errors->has('editState.comment'))
                        @error('editState.comment')
                            <p class="block text-xs text-red-500 sm:hidden">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
                <div class="mt-3 flex items-center justify-end sm:justify-between">
                    <div>
                        @if ($errors->has('editState.comment'))
                            @error('editState.comment')
                                <p class="mt-2 hidden text-sm text-red-500 sm:block">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div class="flex items-center">
                        <div
                            wire:click="cancelIsEditing"
                            class="mr-4 cursor-pointer text-sm font-medium text-gray-500 hover:text-gray-400 sm:text-base">
                            {{ __('Cancel') }}
                        </div>
                        <x-buttons.primary-button type="submit">
                            {{ __('Comment') }}
                        </x-buttons.primary-button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <p class="comment-body my-3 w-full break-words pr-4 text-base dark:text-slate-200">
            {!! makeClickableLinks(nl2br(e($comment->comment))) !!}
        </p>
    @endif
    <div class="flex items-center justify-between">
        @auth
            @if (!$comment->parent_id)
                <button wire:click="$toggle('isReplying')" type="button">
                    <span class="link flex text-sm">{{ __('Reply') }}</span>
                </button>
            @else
                <button wire:click="$toggle('isReplying')" type="button">
                    <div class="flex items-center">
                        <span class="link text-sm">{{ __('Reply') }}</span>
                    </div>
                </button>
            @endif
        @endauth
        <livewire:front.vote :model="$comment" />
    </div>

    {{-- Reply --}}
    <div class="my-1 sm:my-4">
        @if ($isReplying)
            <div wire:target="cancelIsReplying"
                class="@error('editState.comment') border-red-500 @enderror rounded-md border border-gray-200 bg-white p-4 hover:border-primary-500/20 hover:shadow-sm focus:border-primary-500/20 focus:ring-primary-500/20 dark:border-slate-50/[0.06] dark:bg-slate-800">
                <form wire:submit="postReply">
                    <div>
                        <label for="comment" class="sr-only">{{ __('Comment body') }}</label>
                        <textarea wire:model="replyState.comment"
                            x-data="{
                                resize: () => {
                                    $el.style.height = '40px';
                                    $el.style.height = $el.scrollHeight + 'px'
                                }
                            }"
                            x-init="resize"
                            x-on:input="resize"
                            id="comment"
                            name="comment"
                            class="mb-8 block w-full overflow-hidden border-transparent p-0 focus:border-transparent focus:outline-none focus:ring-0 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-200"
                            placeholder="Write something">
                    </textarea>
                        @if ($errors->has('replyState.comment'))
                            @error('replyState.comment')
                                <p class="block text-xs text-red-500 sm:hidden">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div class="mt-3 flex items-center justify-end sm:justify-between">
                        <div>
                            @if ($errors->has('replyState.comment'))
                                @error('replyState.comment')
                                    <p class="mt-2 hidden text-sm text-red-500 sm:block">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                        <div class="flex items-center">
                            <div wire:click="cancelIsReplying"
                                class="mr-4 cursor-pointer text-sm font-medium text-gray-500 hover:text-gray-400 sm:text-base">
                                {{ __('Cancel') }}
                            </div>
                            <x-buttons.primary-button type="submit">
                                {{ __('Comment') }}
                            </x-buttons.primary-button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <div class="replies">
            @foreach ($comment->replies as $reply)
                <div @if ($reply) class="reply" @endif>
                    <livewire:front.comments.comment :comment="$reply" :key="$reply->id" :story="$story" />
                </div>
            @endforeach
        </div>
    </div>
</div>
