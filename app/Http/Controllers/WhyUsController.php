<?php

namespace App\Http\Controllers;

use App\Models\WhyUs;
use Illuminate\Http\Request;

class WhyUsController extends Controller
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
        $data['why'] = WhyUs::orderBy('created_at', 'desc')->where('is_definition',0)->get();
        $data['whyContent'] = WhyUs::where('is_definition',1)->first();
        return view('Backend.WhyUs.index', $data);
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

            $image = $request->file('image');
            $file = new WhyUs();

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/whyus'), $imageName);
            $file->create([
                'image' => $imageName,
                'title' => $request['title'],
                'description' => $request['description'],
            ]);
            return redirect()->back()->withSuccess_message('Why Us Added Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WhyUs  $whyUs
     * @return \Illuminate\Http\Response
     */
    public function show(WhyUs $whyUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WhyUs  $whyUs
     * @return \Illuminate\Http\Response
     */
    public function edit(WhyUs $whyUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WhyUs  $whyUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $image = $request->file('image');
            $file = WhyUs::find($id);

            if($image){
                $path = $file['image'];
                if (file_exists($path)){
                    unlink($path);
                }
                $imageName = time() . ('.' . $image->getClientOriginalExtension());
                $image->move(public_path('images/whyus'), $imageName);
                $file->image = $imageName;
            }
            $file->title = $request['title'];
            $file->description = $request['description'];
            $file->why_us_title = $request['why_us_title'];
            $file->why_us_content = $request['why_us_content'];
            $file->save();
            return redirect()->back()->withSuccess_message('Content Updated Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WhyUs  $whyUs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $why = WhyUs::find($id);
            $path = $why['image'];
            if (file_exists($path)){
                unlink($path);
            }
            $why->delete();
            return response()->json([
                'type'=>'success',
                'message'=>'Why Us content deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'type'=>'error',
                'message'=>'Why Us content can not deleted.'
            ], 422);
//            return $e->getMessage();
        }
    }
}
