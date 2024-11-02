<?php

namespace App\Livewire\Front\User;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class Avatar extends Component
{
    use WithFileUploads;

    public $user;

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
                ! is_null($this->user->avatar) && Storage::disk('local')->delete($this->user->avatar);
                $avatar = $this->avatar->store('avatars', 'local');
            }

            Image::load(storage_path('app/uploads/'.$avatar))
                ->manualCrop($this->width, $this->height, $this->x, $this->y)
                ->fit(Manipulations::FIT_MAX, 300, 300)
                ->save();
        } else {
            if ($this->avatar) {
                ! is_null($this->user->avatar) && Storage::disk(getCurrentDisk())->delete($this->user->avatar);

                Image::load(storage_path('app/temp/livewire-tmp/'.$this->avatar->getFilename()))
                    ->manualCrop($this->width, $this->height, $this->x, $this->y)
                    ->fit(Manipulations::FIT_MAX, 300, 300)
                    ->save();

                $avatar = $this->avatar->storePublicly('avatars', getCurrentDisk());
            }
        }

        auth()->user()->update(compact('avatar'));

        $this->dispatch('refresh')->self();
        $this->avatar = null;
        $this->uploadAvatar = null;
    }

    public function render()
    {
        return view('livewire.front.user.avatar');
    }
}
