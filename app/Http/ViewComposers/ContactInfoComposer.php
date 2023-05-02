<?php

namespace App\Http\ViewComposers;

use App\Models\GeneralSetting;
use Illuminate\View\View;

class ContactInfoComposer
{
    public function compose(View $view)
    {
        $data = GeneralSetting::select('key', 'value')
            ->where('type', 'contact')
            ->get();

        $contact_info = [];

        foreach ($data as $item) {
            $contact_info[$item->key] = $item->value;
        }

        $view->with('contact_info', $contact_info);
    }
}
