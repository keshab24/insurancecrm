<?php

namespace App\Http\ViewComposers;

use App\Models\GeneralSetting;
use Illuminate\View\View;

class GeneralSettingsComposer
{
    public function compose(View $view)
    {
        $data = GeneralSetting::select('key', 'value')
            ->get();

        $general_settings = [];

        foreach ($data as $item) {
            $general_settings[$item->key] = $item->value;
        }

        $view->with('general_settings', $general_settings);
    }
}
