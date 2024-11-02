<?php

namespace App\Services;

class PWAManifestService
{
    public function generate()
    {
        $basicManifest = [
            'name' => config('pwa.manifest.name'),
            'short_name' => config('pwa.manifest.short_name'),
            'start_url' => asset(config('pwa.manifest.start_url')),
            'display' => config('pwa.manifest.display'),
            'theme_color' => config('pwa.manifest.theme_color'),
            'background_color' => config('pwa.manifest.background_color'),
            'orientation' =>  config('pwa.manifest.orientation'),
            'status_bar' =>  config('pwa.manifest.status_bar'),
        ];

        foreach (config('pwa.manifest.icons') as $size => $file) {
            $fileInfo = pathinfo($file['path']);
            $basicManifest['icons'][] = [
                'src' => $file['path'],
                'type' => 'image/'.$fileInfo['extension'],
                'sizes' => (isset($file['sizes'])) ? $file['sizes'] : $size,
                'purpose' => $file['purpose'],
            ];
        }

        return $basicManifest;
    }
}
