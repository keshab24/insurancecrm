<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $links = SocialLink::all();
        return view('SocialLink.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('SocialLink.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'icon' => 'required',
            'position' => 'required'
        ]);

        $data = new SocialLink();
        $data->title = $request->title;
        $data->link = $request->link;
        $data->icon = $request->icon;
        $data->position = $request->position;
        $data->is_active = $request->is_active;
        $data->save();

        return redirect()->route('social-link.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $link = SocialLink::findOrFail($id);
        return view('SocialLink.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'icon' => 'required',
            'position' => 'required'
        ]);

        $data = SocialLink::findOrFail($id);
        $data->title = $request->title;
        $data->link = $request->link;
        $data->icon = $request->icon;
        $data->position = $request->position;
        $data->is_active = $request->is_active;
        $data->save();

        return redirect()->route('social-link.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        $link = SocialLink::findOrFail($id);
        $link->delete();
        return 'Social Link Deleted Successfully.';
    }
}
