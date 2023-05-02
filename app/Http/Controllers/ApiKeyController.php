<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['apiKeys'] = ApiKey::latest()->get();
        return view('Backend.ApiKey.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rand = random_bytes(32); // chiper = AES-256-CBC ? 32 : 16
        $key =  ('base64:'.base64_encode($rand));
        ApiKey::create(["api_key"=>$key]);
        return redirect()->back()->withSuccessMessage('Api Key Created Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApiKey  $apiKey
     * @return \Illuminate\Http\Response
     */
    public function show(ApiKey $apiKey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApiKey  $apiKey
     * @return \Illuminate\Http\Response
     */
    public function edit(ApiKey $apiKey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApiKey  $apiKey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApiKey $apiKey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApiKey  $apiKey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $key = ApiKey::findOrFail($id);
            $key->delete();
            return response()->json([
                'status' => 'ok',
                'message' => 'Key is deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Key can not be deleted.'
            ], 422);
        }
    }
}
