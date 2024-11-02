<?php

namespace App\Livewire\Front\User;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;

class CoverImage extends Component
{
    use WithFileUploads;

    public $user;

    public $coverImage;

    public $uploadCoverImage;

    public $x;

    public $y;

    public $width;

    public $height;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function changeCoverImage()
    {
        if (getCurrentDisk() === 'local') {
            if ($this->coverImage) {
                ! is_null($this->user->cover_image) && Storage::disk('local')->delete($this->user->cover_image);
                $cover = $this->coverImage->store('covers', 'local');
            }

            Image::load(storage_path('app/uploads/'.$cover))
                ->manualCrop($this->width, $this->height, $this->x, $this->y)
                ->save();
        } else {
            if ($this->coverImage) {
                ! is_null($this->user->cover_image) && Storage::disk(getCurrentDisk())->delete($this->user->cover_image);

                Image::load(storage_path('app/temp/livewire-tmp/'.$this->coverImage->getFilename()))
                    ->manualCrop($this->width, $this->height, $this->x, $this->y)
                    ->save();

                $cover = $this->coverImage->storePublicly('covers', getCurrentDisk());
            }
        }

        auth()->user()->update([
            'cover_image' => $cover,
        ]);

        $this->dispatch('refresh')->self();
        $this->coverImage = null;
        $this->uploadCoverImage = null;
    }

    public function render()
    {
        return view('livewire.front.user.cover-image');
    }
}
