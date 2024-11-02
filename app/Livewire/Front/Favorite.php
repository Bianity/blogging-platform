<?php

namespace App\Livewire\Front;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Favorite extends Component
{
    public Model $model;

    public function toggleFavorite()
    {
        $user = User::find(auth()->id());
        $user->toggleFavorite($this->model);
    }

    public function render()
    {
        return view('livewire.front.favorite');
    }
}
