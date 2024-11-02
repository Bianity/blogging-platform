<?php

namespace App\Livewire\Front\Community;

use App\Models\Community;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class Avatar extends Component
{
    use WithFileUploads;

    public $community;

    public $avatar;

    public $uploadAvatar;

    public $height;

    public $width;

    public $x;

    public $y;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function changeAvatar()
    {
        if (getCurrentDisk() === 'local') {
            if ($this->avatar) {
                ! is_null($this->community->avatar) && Storage::disk('local')->delete($this->community->avatar);
                $avatar = $this->avatar->store('avatars', 'local');
            }

            Image::load(storage_path('app/uploads/'.$avatar))
                ->manualCrop($this->width, $this->height, $this->x, $this->y)
                ->fit(Manipulations::FIT_MAX, 300, 300)
                ->save();
        } else {
            if ($this->avatar) {
                ! is_null($this->community->avatar) && Storage::disk(getCurrentDisk())->delete($this->community->avatar);

                Image::load(storage_path('app/temp/livewire-tmp/'.$this->avatar->getFilename()))
                    ->manualCrop($this->width, $this->height, $this->x, $this->y)
                    ->fit(Manipulations::FIT_MAX, 300, 300)
                    ->save();

                $avatar = $this->avatar->storePublicly('avatars', getCurrentDisk());
            }
        }

        $community = Community::findOrFail($this->community->id);

        $community->update(compact('avatar'));

        $this->dispatch('refresh')->self();
        $this->avatar = null;
        $this->uploadAvatar = null;
    }

    public function render()
    {
        return view('livewire.front.community.avatar');
    }
}
