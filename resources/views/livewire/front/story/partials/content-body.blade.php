{{-- Story audio --}}
@if ($story->getMedia('story-audio')->isNotEmpty())
    <div class="w-content relative my-3">
        <audio id="player" controls>
            <source src="{{ $story->getFirstMediaUrl('story-audio') }}" alt="audio">
            {{ __('Your browser does not support the audio tag.') }}
        </audio>
    </div>
@endif
{{-- Content Body --}}
<div class="content-wrapper">
    <div class="mt-3">
        {!! $story->body_rendered !!}
    </div>
    @if (isset($story->poll))
        <div class="w-content mt-3">
            <livewire:front.poll.show :story="$story" />
        </div>
    @endif
    @if (isset($story->tags))
        <div class="w-content my-3 flex items-center">
            @foreach ($story->tags as $tag)
                <a href="{{ route('tag.show', ['tag' => $tag->normalized]) }}"
                    class="mr-4 text-base font-bold">{{ '#' . $tag->name }}</a>
            @endforeach
        </div>
    @endif
    @if (isset($story->meta['meta_canonical_url']))
        <div
            class="w-content my-4 flex items-center rounded-md bg-primary-50 dark:bg-primary-900 dark:bg-opacity-30">
            <div class="px-1 py-5 sm:p-5">
                {{ __('Originally posted on: ') }} <a
                    href="{{ $story->meta['meta_canonical_url'] }}"
                    target="_blank"
                    class="ml-1"
                    rel="noopener noreferrer">{{ $story->meta['meta_canonical_url'] }}</a>
            </div>
        </div>
    @endif
</div>
{{-- Footer Body --}}
<div class="w-content">
    <div class="mt-6 flex items-center justify-between">
        <div class="flex items-center">
            {{-- Comments Count --}}
            <a href="#comment"
                class="item-center group mr-4 flex md:mr-7">
                <div
                    class="mr-[6px] flex h-8 w-8 items-center justify-center rounded-lg group-hover:bg-primary-500/10">
                    <x-icons.comments
                        class="h-5 w-5 text-gray-600 group-hover:text-primary-500 dark:text-slate-200" />
                </div>
                <div
                    class="text-md flex items-center font-medium leading-5 text-gray-600 group-hover:text-primary-500 dark:text-slate-200">
                    {{ $story->allComments()->count() }}</div>
            </a>
            {{-- Views --}}
            @if ($story->isPublished())
                <div class="mr-4 flex items-center md:mr-7">
                    <x-icons.eye
                        class="mr-[6px] h-5 w-5 text-gray-600 dark:text-slate-200" />
                    <div
                        class="time text-base font-medium text-gray-600 dark:text-slate-200">
                        {{ views($story)->remember()->count() }}
                    </div>
                </div>
            @endif
            {{-- Save --}}
            @if (auth()->id() !== $story->user->id)
                <livewire:front.favorite :model="$story" :key="$story->id" />
            @endif
            {{-- Social Share --}}
            <x-buttons.share :story="$story" />
        </div>
        @if ($story->isPublished())
            <div class="flex items-center">
                <livewire:front.vote :model="$story" :key="$story->id" />
            </div>
        @endif
    </div>
</div>
