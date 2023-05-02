<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function languageChange(Request $request){
        App::setlocale($request->lang);
        session()->put('locale', $request->lang);
        return redirect()->back();
    }
}
