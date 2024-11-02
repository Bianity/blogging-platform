<?php

namespace App\View\Components\Menu;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Footer extends Component
{
    public function render()
    {
        $footerMenu = Cache::remember('footerMenu', now()->addMinutes(60), function () {
            return Page::select(['title', 'slug'])->where('show_footer_menu', true)->get();
        });

        return view('components.menu.footer', compact('footerMenu'));
    }
}
