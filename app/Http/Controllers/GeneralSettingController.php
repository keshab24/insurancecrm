<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $settings = GeneralSetting::all();

        return view('GeneralSetting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('GeneralSetting.create');
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
            'key' => 'required|unique:general_settings',
            'value' => 'required',
            'type' => 'required',
        ]);

        GeneralSetting::create([
            'key' => $request->key,
            'value' => $request->value,
            'type' => $request->type,
            'is_deletable' => $request->is_deletable,
        ]);
//        return $request;
        if ($request->type == 'contact') {
            return redirect()->route('general-setting.contact');
        }
        return redirect()->route('general-setting.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $setting = GeneralSetting::findOrFail($id);

        return view('GeneralSetting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
            'type' => 'required',
        ]);

        $setting = GeneralSetting::findOrFail($id);
        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
            'type' => $request->type,
            'is_deletable' => $setting->is_deletable,
        ]);
        if ($request->type == 'contact') {
            return redirect()->route('general-setting.contact');
        }
        return redirect()->route('general-setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     */
    public function destroy($id)
    {
        $setting = GeneralSetting::findOrFail($id);

        $setting->delete();

        return 'Setting deleted successfully.';
    }

    public function contactList()
    {
        $settings = GeneralSetting::where('type', 'contact')->get();

        return view('GeneralSetting.ContactPage.index', compact('settings'));
    }

    public function contactCreate()
    {
        return view('GeneralSetting.ContactPage.create');
    }
    public function contactEdit($id)
    {
        $setting = GeneralSetting::findOrFail($id);

        return view('GeneralSetting.ContactPage.edit', compact('setting'));
    }
}
