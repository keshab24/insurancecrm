<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ImelifeController extends Controller
{
    public function imelife()
    {

       
        return view('imelife.ime_life');
    }

    public function postimeOne(Request $request)
    {
        
        return redirect()->route('admin.ime.life.two');
    }
    public function imelifetwo()
    {

        $products = Product::orderBy('created_at', 'asc')->get();
        return view('imelife.ime_life_second')->with('products', $products);
    }
    public function postimeTwo(Request $request)
    {
        
        return redirect()->route('admin.ime.life.three');
    }
    public function imelifethree()
    {

        
        return view('imelife.ime_life_third');
    }
    public function postimeThree(Request $request)
    {
        
        return redirect()->route('admin.ime.life.four');
    }
    public function imelifefour()
    {

        return view('imelife.ime_life_four');
    }
    public function postimefour(Request $request)
    {
        
        return redirect()->route('admin.ime.life.five');
    }
    public function imelifefive()
    {

        return view('imelife.ime_life_fifth');
    }
    public function postimeFive(Request $request)
    {
        
        return redirect()->route('admin.ime.life.six');
    }
    public function imelifesix()
    {

        return view('imelife.ime_life_sixth');
    }
}
