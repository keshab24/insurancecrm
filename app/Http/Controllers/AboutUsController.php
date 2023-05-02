<?php

namespace App\Http\Controllers;

use App\Models\AboutWe;
use Illuminate\Http\Request;

class AboutUsController extends Controller
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
        $data['about'] = AboutWe::orderBy('created_at', 'desc')->where('is_definition',0)->get();
        $data['aboutContent'] = AboutWe::where('is_definition',1)->first();
        return view('Backend.AboutUs.index', $data);
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
            $file = new AboutWE();

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/aboutus'), $imageName);
            $file->create([
                'image' => $imageName,
                'title' => $request['title'],
                'description' => $request['description'],
            ]);
            return redirect()->back()->withSuccess_message('About Us Added Successfully !');
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
            $image = $request->file('image');
            $file = AboutWe::find($id);

            if($image){
                $path = $file['image'];
                if (file_exists($path)){
                    unlink($path);
                }
                $imageName = time() . ('.' . $image->getClientOriginalExtension());
                $image->move(public_path('images/aboutus'), $imageName);
                $file->image = $imageName;
            }
            $file->title = $request['title'];
            $file->description = $request['description'];
            $file->about_us_title = $request['about_us_title'];
            $file->about_us_content = $request['about_us_content'];
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
            $why = AboutWe::find($id);
            $path = $why['image'];
            if (file_exists($path)){
                unlink($path);
            }
            $why->delete();
            return redirect()->back()->withWarning_message('About Us Content Deleted !');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
