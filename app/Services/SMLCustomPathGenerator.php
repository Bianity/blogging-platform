<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class SMLCustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media).'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media).'/cons/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media).'/rimg/';
    }

    protected function getBasePath(Media $media): string
    {
        $prefixStories = config('media-library.prefix-stories', '');

        if ($prefixStories !== '') {
            return $prefixStories.'/'.$media->getKey();
        }

        return $media->getKey();
    }
}
