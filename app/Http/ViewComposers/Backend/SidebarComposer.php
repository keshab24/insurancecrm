<?php

namespace App\Http\ViewComposers\Backend;

use Illuminate\View\View;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Cache;
use Session;

class SidebarComposer
{
    /**
     * Bind data to the View
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = auth()->user();
        $view->with('user', $user);
    }
}
