<div class="flex max-w-[100px] items-center justify-center gap-2 font-medium" x-data="{
    voteCount: @entangle('voteCount').live,
    isUpVoted: @entangle('isUpVoted').live,
    isDownVoted: @entangle('isDownVoted').live,
    actualVotes: @entangle('actualVotes').live,
    upVote() {
        if (this.isDownVoted) {
            this.undoDownVote();
        }

        if (this.isUpVoted) {
            this.undoUpVote();
        } else {
            this.isUpVote = true;
            this.voteCount++;
        }

        $wire.upVote();
    },
    downVote() {
        if (this.isUpVoted) {
            this.undoUpVote();
        }

        if (this.isDownVoted) {
            this.undoDownVote();
        } else {
            this.isDownVote = true;
            this.voteCount--;
        }
        $wire.downVote();
    },
    undoUpVote() {
        this.isUpVoted = false;
        this.voteCount--;
    },
    undoDownVote() {
        this.isDownVoted = false;
        this.voteCount++;
    },
}">
    @auth
        <button @click.prevent="downVote"
            class="group relative flex h-8 w-8 cursor-pointer items-center justify-center bg-transparent hover:rounded-full hover:bg-red-500/10"
            aria-label="{{ __('downVote') }}">
            <x-icons.arrows.arrow-down class="h-6 w-6 text-gray-500 group-hover:text-red-500 dark:text-slate-200"
                x-bind:class="isDownVoted ? 'text-red-500 dark:text-red-500' : ''" />
        </button>
        @if ($actualVotes === 0)
            <div class="grow items-center justify-center text-gray-500 dark:text-slate-200"
                x-bind:class="(isUpVoted ? 'text-emerald-500 dark:text-emerald-500' : '') || (isDownVoted ?
                    'text-red-500 dark:text-red-500' : '')"
                x-text="voteCount"></div>
        @else
            <div class="@if ($actualVotes) text-emerald-500 @else text-red-500 @endif grow items-center justify-center"
                x-bind:class="(isUpVoted ? 'text-emerald-500 dark:text-emerald-500' : '') || (isDownVoted ?
                    'text-red-500 dark:text-red-500' : '')"
                x-text="voteCount"></div>
        @endif
        <button @click.prevent="upVote"
            class="group relative flex h-8 w-8 cursor-pointer items-center justify-center bg-transparent hover:rounded-full hover:bg-emerald-500/10"
            aria-label="{{ __('upVote') }}">
            <x-icons.arrows.arrow-up class="h-6 w-6 text-gray-500 group-hover:text-emerald-500 dark:text-slate-200"
                x-bind:class="isUpVoted ? 'text-emerald-500 dark:text-emerald-500' : ''" />
        </button>
    @else
        <a href="{{ route('login') }}"
            class="group relative flex h-8 w-8 cursor-pointer items-center justify-center bg-transparent hover:rounded-full hover:bg-red-500/10"
            aria-label="{{ __('Vote') }}">
            <x-icons.arrows.arrow-down class="h-6 w-6 text-gray-500 group-hover:text-red-500 dark:text-slate-200"
                x-bind:class="isDownVoted ? 'text-red-500' : ''" />
        </a>
        @if ($actualVotes === 0)
            <div class="grow items-center justify-center text-gray-500 dark:text-slate-200" x-text="voteCount"></div>
        @else
            <div class="@if ($actualVotes) text-emerald-500 @else text-red-500 @endif grow items-center justify-center"
                x-text="voteCount"></div>
        @endif
        <a href="{{ route('login') }}"
            class="group relative flex h-8 w-8 cursor-pointer items-center justify-center bg-transparent hover:rounded-full hover:bg-emerald-500/10"
            aria-label="{{ __('Vote') }}">
            <x-icons.arrows.arrow-up class="h-6 w-6 text-gray-500 group-hover:text-emerald-500 dark:text-slate-200"
                x-bind:class="isUpVoted ? 'text-emerald-500 dark:text-emerald-500' : ''" />
        </a>
    @endauth
</div>
