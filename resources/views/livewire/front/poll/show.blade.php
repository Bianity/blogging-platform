@php
    switch ($poll->poll_style) {
        case $poll->poll_style == 'primary':
            $themePoll = 'bg-primary-500';
            break;
        case $poll->poll_style == 'lime':
            $themePoll = 'bg-gradient-to-r from-lime-500 to-lime-600';
            break;
        case $poll->poll_style == 'purple':
            $themePoll = 'bg-gradient-to-br from-purple-600 to-blue-500';
            break;
    }
@endphp
<div>
    <div class="mb-2 text-lg font-bold sm:text-xl lg:text-2xl">{{ $poll->question }}</div>
    @auth
        @if (!auth()->user()->hasPollVoted($poll->id) && $poll->poll_ends >= now())
            @foreach ($choices as $choice)
                <div class="mb-2">
                    <x-button full primary shadowless wire:click="castVote({{ $choice->id }})" outline>
                        {{ $choice->text }}
                    </x-button>
                </div>
            @endforeach
        @else
            @foreach ($choices as $choice)
                <div class="mb-3">
                    @if ($poll->votes->count())
                        <div class="mb-1 flex justify-between">
                            <span class="flex items-center text-base font-medium text-slate-900 dark:text-white">
                                {{ $choice->text }}
                                @if (auth()->user()->isChosenByUser(getCurrentUser()->id, $choice->id))
                                    <x-icons.check class="text-bold ml-2 h-3.5 shrink-0" />
                                @endif
                            </span>
                            <span
                                class="text-sm font-medium text-slate-900 dark:text-white">{{ round(($choice->votes->count() / $poll->votes->count()) * 100, 2) . '%' }}</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="{{ $themePoll }} h-2.5 rounded-full"
                                style="width: {{ round(($choice->votes->count() / $poll->votes->count()) * 100, 2) }}%;">
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    @else
        @if ($poll->poll_ends < \Carbon\Carbon::now())
            @foreach ($choices as $choice)
                <div class="mb-3">
                    @if ($poll->votes->count())
                        <div class="mb-1 flex justify-between">
                            <span class="flex items-center text-base font-medium text-slate-900 dark:text-white">
                                {{ $choice->text }}
                            </span>
                            <span
                                class="text-sm font-medium text-slate-900 dark:text-white">{{ round(($choice->votes->count() / $poll->votes->count()) * 100, 2) . '%' }}</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="{{ $themePoll }} h-2.5 rounded-full"
                                style="width: {{ round(($choice->votes->count() / $poll->votes->count()) * 100, 2) }}%;">
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            @foreach ($choices as $choice)
                <div class="mb-2">
                    <x-button full primary shadowless href="{{ route('login') }}" outline>{{ $choice->text }}</x-button>
                </div>
            @endforeach
        @endif

    @endauth

    <div class="flex items-center space-x-2 text-gray-500 dark:text-slate-400">
        @if ($poll->votes->count() > 0)
            <span>{{ $poll->votes->count() }}</span>
            <span>{{ $poll->votes()->count() === 1 ? __('vote') : __('votes') }}</span>
        @endif
        <span>{{ $poll->displayHumanTimeLeft() }}</span>
    </div>
</div>
