<?php

namespace App\Livewire\Front\User\Dashboard\Following;

use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $user;

    public $perPage = 10;

    public function render()
    {
        $followings = $this->user->followings()->where('followable_type', 'App\Models\User')->paginate($this->perPage);

        return view('livewire.front.user.dashboard.following.users', compact('followings'));
    }
}
