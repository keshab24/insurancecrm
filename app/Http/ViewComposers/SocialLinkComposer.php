<?php

namespace App\Http\ViewComposers;

use App\Models\SocialLink;
use Illuminate\View\View;

class SocialLinkComposer
{
    public function compose(View $view)
    {
        $links = SocialLink::select('link', 'icon')
            ->where('is_active', true)
            ->orderBy('position', 'asc')
            ->get();

        $view->with('links', $links);
    }
}
