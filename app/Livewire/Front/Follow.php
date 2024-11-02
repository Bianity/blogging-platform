<?php

namespace App\Livewire\Front;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Follow extends Component
{
    public Model $model;

    public function toggleFollow()
    {
        $user = User::find(auth()->id());
        $user->toggleFollow($this->model);
    }

    public function render()
    {
        return view('livewire.front.follow');
    }
}
