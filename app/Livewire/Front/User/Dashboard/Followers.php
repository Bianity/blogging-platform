<?php

namespace App\Livewire\Front\User\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;

class Followers extends Component
{
    use WithPagination;

    public $user;

    public $perPage = 10;

    public function render()
    {
        $followers = $this->user->followers()->paginate($this->perPage);

        return view('livewire.front.user.dashboard.followers', compact('followers'));
    }
}
