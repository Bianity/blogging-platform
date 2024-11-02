<?php

namespace App\Livewire\Front\Community;

use App\Models\Community;
use Livewire\Component;

class Create extends Component
{
    public $communityName;

    public $communityDescription;

    public $communityRules;

    protected $rules = [
        'communityName' => ['required', 'min:3', 'max:30', 'regex:/^[\pL0-9\s]+$/u'],
        'communityDescription' => ['required', 'min:10', 'max:200'],
        'communityRules' => ['sometimes', 'nullable', 'min:15', 'max:1000'],
    ];

    public function createCommunity()
    {
        $this->validate();

        $community = Community::create([
            'user_id' => auth()->id(),
            'name' => $this->communityName,
            'description' => $this->communityDescription,
            'rules' => $this->communityRules,
        ]);

        return redirect()->route('community.show', ['community' => $community->slug]);
    }

    public function render()
    {
        return view('livewire.front.community.create');
    }
}
