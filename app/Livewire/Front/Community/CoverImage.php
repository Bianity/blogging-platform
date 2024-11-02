<?php

namespace App\Livewire\Front\Community;

use App\Models\Community;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;

class CoverImage extends Component
{
    use WithFileUploads;

    public $community;

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
                ! is_null($this->community->cover_image) && Storage::disk('local')->delete($this->community->cover_image);
                $cover = $this->coverImage->store('covers', 'local');
            }

            Image::load(storage_path('app/uploads/'.$cover))
                ->manualCrop($this->width, $this->height, $this->x, $this->y)
                ->save();
        } else {
            if ($this->coverImage) {
                ! is_null($this->community->cover_image) && Storage::disk(getCurrentDisk())->delete($this->community->cover_image);

                Image::load(storage_path('app/temp/livewire-tmp/'.$this->coverImage->getFilename()))
                    ->manualCrop($this->width, $this->height, $this->x, $this->y)
                    ->save();

                $cover = $this->coverImage->storePublicly('covers', getCurrentDisk());
            }
        }

        $community = Community::findOrFail($this->community->id);

        $community->update([
            'cover_image' => $cover,
        ]);

        $this->dispatch('refresh')->self();
        $this->coverImage = null;
        $this->uploadCoverImage = null;
    }

    public function render()
    {
        return view('livewire.front.community.cover-image');
    }
}
