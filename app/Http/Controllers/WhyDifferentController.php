<?php

namespace App\Http\Controllers;

use App\Models\WhyDifferent;
use Illuminate\Http\Request;

class WhyDifferentController extends Controller
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
        $data['why'] = WhyDifferent::orderBy('created_at', 'desc')->where('is_definition', 0)->get();
        $data['whyContent'] = WhyDifferent::where('is_definition', 1)->first();
//        return $data;
        return view('Backend.WhyDifferent.index', $data);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $image = $request->file('image');
            $file = new WhyDifferent();

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/whyDifferent'), $imageName);
            $file->create([
                'image' => $imageName,
                'title' => $request['title'],
                'description' => $request['description'],
            ]);
            return redirect()->back()->withSuccess_message('Why Different Added Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\WhyDifferent $whyDifferent
     * @return \Illuminate\Http\Response
     */
    public function show(WhyDifferent $whyDifferent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\WhyDifferent $whyDifferent
     * @return \Illuminate\Http\Response
     */
    public function edit(WhyDifferent $whyDifferent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\WhyDifferent $whyDifferent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $image = $request->file('image');
            $file = WhyDifferent::find($id);
            if($image){
                $path = $file['image'];
                if (file_exists($path)){
                    unlink($path);
                }
                $imageName = time() . ('.' . $image->getClientOriginalExtension());
                $image->move(public_path('images/whyDifferent'), $imageName);
                $file->image = $imageName;
            }
            $file->title = $request['title'];
            $file->description = $request['description'];
            $file->why_diff_title = $request['why_diff_title'];
            $file->why_diff_content = $request['why_diff_content'];
            $file->save();
            return redirect()->back()->withSuccess_message('Content Updated Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\WhyDifferent $whyDifferent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $why = WhyDifferent::find($id);
            $path = $why['image'];
            if (file_exists($path)){
                unlink($path);
            }
            $why->delete();
            return response()->json([
                'type'=>'success',
                'message'=>'Why Different content deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'type'=>'error',
                'message'=>'Why Different content can not deleted.'
            ], 422);
//            return $e->getMessage();
        }
    }
}
