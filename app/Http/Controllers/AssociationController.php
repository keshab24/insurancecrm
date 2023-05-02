<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
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
        $data['associations'] = Association::orderBy('created_at', 'desc')->get();
        return view('Backend.Association.index', $data);
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
            $file = new Association();

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/association'), $imageName);
            $file->create([
                'image' => $imageName,
                'name' => $request['name'],
                'association_type' => $request['association_type'],
                'status' => true,

            ]);
            return redirect()->back()->withSuccess_message('Association Added Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function show(Association $association)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function edit(Association $association)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $image = $request->file('image');
            $file = Association::find($id);
            if ($image) {
                $path = $file['image'];
                if (file_exists($path)) {
                    unlink($path);
                }
                $imageName = time() . ('.' . $image->getClientOriginalExtension());
                $image->move(public_path('images/association'), $imageName);
                $file->image = $imageName;
            }
            $file->name = $request['name'];
            $file->association_type = $request['association_type'];
            $file->save();
            return redirect()->back()->withSuccess_message('Association Updated Successfully !');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $association = Association::find($id);
            $path = $association['image'];
            if (file_exists($path)) {
                unlink($path);
            }
            $association->delete();
            return response()->json([
                'type'=>'success',
                'message'=>'Association is deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
//            return $e->etMessage();
            return response()->json([
                'type'=>'error',
                'message'=>'Association can not deleted.'
            ], 422);
        }
    }

    public function statusChange($id)
    {
        try {
            $association = Association::find($id);
            if ($association->status == 1) {
                $association->status = 0;
            } else {
                $association->status = 1;
            }
            $association->update();
            return response()->json([
                'type'=>'success',
                'association' => $association,
                'message'=>'Active status changed successfully.'
            ], 200);
        }catch (\Exception $e) {
//            return $e->getMessage();
            return response()->json([
                'type'=>'error',
                'association' => $association,
                'message'=>'Association can not deleted.'
            ], 422);
        }
    }
}
