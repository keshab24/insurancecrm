<?php

namespace App\Http\Controllers;

use App\Models\Planselected;
use Illuminate\Http\Request;

class PlanselectedController extends Controller
{


    public function index()
    {
            $selected = Planselected::all();
            return view('Backend.planselected.index')->with('selected', $selected);
       
    }

    //
    public function store(Request $request)
    {
       $selected = Planselected::create($request->all());

        if ($selected) {
            return response()->json([
                'status' => 'ok',
                'user' => $selected,
                'message' => 'Plan is added successfully.'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Plan can not be selected.'
            ], 422);
        }
    }
}
