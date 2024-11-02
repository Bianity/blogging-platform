<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait HasUploadWithEditorJs
{
    public $uploads = [];

    public function completedImageUpload(string $uploadedFileName, string $eventName, $fileName = null)
    {
        /** @var TemporaryUploadedFile $tmpFile */
        $tmpFile = collect($this->uploads)
            ->filter(function (TemporaryUploadedFile $item) use ($uploadedFileName) {
                return $item->getFilename() === $uploadedFileName;
            })
            ->first();

        // When no file name is passed, we use the hashName of the tmp file
        $storedFileName = $tmpFile->storeAs(
            '/stories/img',
            $fileName ?? $tmpFile->hashName(),
            getCurrentDisk()
        );

        $this->dispatch($eventName, [
            'url' => Storage::disk(getCurrentDisk())->url($storedFileName),
        ]);
    }

    public function loadImageFromUrl(string $url)
    {
        $name = basename($url);
        $content = file_get_contents($url);

        Storage::disk(getCurrentDisk())->put('/stories/img/'.$name, $content);

        return Storage::disk(getCurrentDisk())->url('/stories/img/'.$name);
    }
}
