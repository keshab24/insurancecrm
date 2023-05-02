<?php

namespace App\Http\Controllers;

use App\Models\Values;
use Illuminate\Http\Request;

class ValuesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (control('frontend-dynamics')) {
        $data['about'] = Values::orderBy('created_at', 'desc')->where('is_definition',0)->get();
        $data['aboutContent'] = Values::where('is_definition',1)->first();
        return view('Backend.Values.index', $data);
    }
        else {
            return view('layouts.backend.denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $file = new Values();

          
            $file->create([
               
                'title' => $request['title'],
                'description' => $request['description'],
            ]);
            return redirect()->back()->withSuccess_message('Core Values Added Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
        
            $file = Values::find($id);

            $file->title = $request['title'];
            $file->description = $request['description'];
            $file->values_title = $request['values_title'];
            $file->values_content = $request['values_content'];
            $file->save();
            return redirect()->back()->withSuccess_message('Content Updated Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $why = Values::find($id);
           
            $why->delete();
            return redirect()->back()->withWarning_message('About Us Content Deleted !');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
