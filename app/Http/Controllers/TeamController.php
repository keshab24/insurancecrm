<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
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
        $data['teams'] = Team::orderBy('created_at', 'desc')->get();
        return view('Backend.Team.index', $data);
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
            $file = new Team();

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/testimonial'), $imageName);
            $file->create([
                'image' => $imageName,
                'name' => $request['name'],
                'designation' => $request['designation'],
                'fb' => $request['fb'],
                'twitter' => $request['twitter'],
                'linkedin' => $request['linkedin'],
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
            $file = Team::find($id);
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
            $file->fb = $request['fb'];
            $file->twitter = $request['twitter'];
            $file->linkedin = $request['linkedin'];
            $file->save();
            return redirect()->back()->withSuccess_message('Team Updated Successfully !');
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
            $testimonial = Team::find($id);
            $path = $testimonial['image'];
            if (file_exists($path)) {
                unlink($path);
            }
            $testimonial->delete();
            return redirect()->back()->withWarning_message('Team Deleted !');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function statusChange($id)
    {
        try {
            $testimonial = Team::find($id);
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
                'message'=>'Team can not deleted.'
            ], 422);
        }
    }
}
