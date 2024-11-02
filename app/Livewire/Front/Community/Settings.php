<?php

namespace App\Livewire\Front\Community;

use App\Models\Community;
use Livewire\Component;
use WireUi\Traits\Actions;

class Settings extends Component
{
    use Actions;

    public $community;

    public $communityName;

    public $communityDescription;

    public $communityRules;

    public function mount($community)
    {
        $this->communityName = $community->name;
        $this->communityDescription = $community->description;
        $this->communityRules = $community->rules;
    }

    protected $rulesCommunityProfile = [
        'communityName' => 'required|min:3|max:30|alpha_space_numeric',
        'communityDescription' => 'required|min:10|max:200',
        'communityRules' => 'sometimes|nullable|min:15|max:1000',
    ];

    public function updateCommunity()
    {
        $this->validate($this->rulesCommunityProfile);
        $community = Community::findOrFail($this->community->id);

        $community->update([
            'name' => $this->communityName,
            'description' => $this->communityDescription,
            'rules' => $this->communityRules,
        ]);

        $this->notification()->success(
            $title = __('Successfully Updated Community!'),
        );
    }

    public function render()
    {
        return view('livewire.front.community.settings');
    }
}
