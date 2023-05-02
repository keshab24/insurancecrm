<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Exception;

class TestimonialController extends Controller
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
        $data['testimonials'] = Testimonial::orderBy('created_at', 'desc')->get();
        return view('Backend.Testimonial.index', $data);
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
            $file = new Testimonial();

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/testimonial'), $imageName);
            $file->create([
                'image' => $imageName,
                'name' => $request['name'],
                'designation' => $request['designation'],
                'comment' => $request['comment'],
                'rating' => $request['rating'],
                'status' => true,

            ]);
            return redirect()->back()->withSuccess_message('Testimonial Added Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Testimonial $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Testimonial $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Testimonial $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $image = $request->file('image');
            $file = Testimonial::find($id);
            if ($image) {
                $path = $file['image'];
                if (file_exists($path)) {
                    unlink($path);
                }
                $imageName = time() . ('.' . $image->getClientOriginalExtension());
                $image->move(public_path('images/testimonial'), $imageName);
                $file->image = $imageName;
            }
            $file->name = $request['name'];
            $file->designation = $request['designation'];
            $file->comment = $request['comment'];
            $file->rating = $request['rating'];
            $file->save();
            return redirect()->back()->withSuccess_message('Testimonial Updated Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Testimonial $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $testimonial = Testimonial::find($id);
            $path = $testimonial['image'];
            if (file_exists($path)) {
                unlink($path);
            }
            $testimonial->delete();
            return response()->json([
                'type'=>'success',
                'message'=>'Testimonial is deleted successfully.'
            ], 200);
//            return redirect()->back()->withWarning_message('Testimonial Deleted !');

        } catch (\Exception $e) {
//            return $e->getMessage();
            return response()->json([
                'type'=>'error',
                'message'=>'Testimonial can not deleted.'
            ], 422);
        }
    }

    public function statusChange($id)
    {
        try {
            $testimonial = Testimonial::find($id);
            if ($testimonial->status == 1) {
                $testimonial->status = 0;
            } else {
                $testimonial->status = 1;
            }
            $testimonial->update();
            return response()->json([
                'type'=>'success',
                'testimonial' => $testimonial,
                'message'=>'Active status changed successfully.'
            ], 200);
        } catch (\Exception $e) {
//            return $e->getMessage();
            return response()->json([
                'type'=>'error',
                'testimonial' => $testimonial,
                'message'=>'Testimonial can not deleted.'
            ], 422);
        }
    }
}
