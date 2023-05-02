<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BenefitController extends Controller
{
    public function index()
    {
        $data['benefits'] = Benefit::all();
        return view('Backend.Benefit.index', $data);
    }

    public function create()
    {
        $data['companies'] = Company::select('id', 'name')->get();
        return view('Backend.Benefit.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'company_id' => 'required',
        ]);

        Benefit::create($request->all());

        return redirect()->route('benefit.index');
    }

    public function edit($id)
    {
        $data['benefit'] = Benefit::findOrFail($id);
        $data['companies'] = Company::select('id', 'name')->get();

        return view('Backend.Benefit.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $benefit = Benefit::findOrFail($id);

        if ($benefit) {
            $benefit->update($request->all());
        }
        return redirect()->route('benefit.index');
    }

    public function destroy($id)
    {
        $benefit = Benefit::findOrFail($id);

        if ($benefit) {
            $benefit->delete();
        }

        return 'Benefit deleted successfully';
    }
}
