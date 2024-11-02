<?php

namespace App\Livewire\Front;

use App\Models\Community;
use App\Models\Story;
use App\Models\User;
use Livewire\Component;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchBar extends Component
{
    public $query = '';

    public $results;

    public function render()
    {
        if (strlen($this->query) > 2) {
            $this->results = collect(Search::new()
                ->add(Story::where('title', 'like', "%{$this->query}%")->orWhere('body_rendered', 'like', "%{$this->query}%")->select('id', 'title', 'slug', 'published_at', 'updated_at')->take(5))
                ->add(User::where('name', 'like', "%{$this->query}%")->select('id', 'name', 'username', 'avatar')->take(3))
                ->add(Community::where('name', 'like', "%{$this->query}%")->select('id', 'name', 'slug', 'avatar')->take(3))
                ->includeModelType()
                ->beginWithWildcard()
                ->orderByModel([
                    User::class, Community::class, Story::class,
                ])
                ->search($this->query));
        }

        return view('livewire.front.search-bar');
    }
}
