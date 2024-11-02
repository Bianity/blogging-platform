<?php

namespace App\Livewire\Front\User\Dashboard;

use App\Models\Story;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use ProtoneMedia\LaravelCrossEloquentSearch\Search as CrossSearch;
use WireUi\Traits\Actions;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use Actions;

    public $search = '';

    public int $perPage = 10;

    public string $sort = 'updated_at|desc';

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortByColumn()
    {
        $sort = explode('|', $this->sort);

        return $sort[0];
    }

    public function sortDirection($results)
    {
        $sort = explode('|', $this->sort);

        if ($sort[1] === 'desc') {
            return $results->orderByDesc();
        }

        return $results;
    }

    public function isPinned($id)
    {
        $story = Story::find($id);
        $this->authorize('edit_stories', $story);

        if ($story->is_pinned === 0) {
            $story->is_pinned = true;
            $story->timestamps = false;
            $story->save();
        } else {
            $story->is_pinned = false;
            $story->timestamps = false;
            $story->save();
        }

        $this->dispatch('refresh');

        $this->notification()->success(
            $title = __('Story successfully was added to pinned collection!'),
        );
    }

    public function deleteStory($id)
    {
        $story = Story::find($id);
        $this->authorize('delete_stories', $story);

        // Important! All related models need to be deleted, before deleting a story
        $story->detag();
        $story->votes()->where('votable_id', '=', $id)->delete();
        $story->favorites()->where('favoriteable_id', '=', $id)->delete();
        $story->allComments()->where('commentable_id', '=', $id)->delete();

        $story->delete();

        $this->dispatch('refresh');

        $this->notification()->success(
            $title = __('Story successfully was deleted!'),
        );
    }

    public function render()
    {
        $items = CrossSearch::new();
        $items->add(Story::where('user_id', auth()->user()->id), ['title'], $this->sortByColumn());
        $items->includeModelType();
        $items = $this->sortDirection($items);

        $stories = $items
            ->paginate($this->perPage)
            ->beginWithWildcard()
            ->search($this->search);

        return view('livewire.front.user.dashboard.index', compact('stories'));
    }
}
