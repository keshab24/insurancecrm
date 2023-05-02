<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CoupleAgeDifference;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CoupleAgeDifferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $ageDifference = CoupleAgeDifference::all();
        return view('Backend.CouplePlan.AgeDifference.index', compact('ageDifference'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $companies = Company::select('id', 'name')
            ->orderBy('name', 'asc')
            ->whereHas('products', function ($query) {
                $query->where('category', 'couple');
            })
            ->get();

        return view('Backend.CouplePlan.AgeDifference.create', compact('companies'));
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
            'company_id' => 'required',
            'product_id' => 'required',
            'age_difference' => 'required',
            'add_age' => 'required',
        ]);

        CoupleAgeDifference::create([
            'company_id' => $request->company_id,
            'product_id' => $request->product_id,
            'age_difference' => $request->age_difference,
            'add_age' => $request->add_age,
        ]);

        return redirect()->route('age-difference.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $companies = Company::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $ageDifference = CoupleAgeDifference::findOrFail($id);

        return view('Backend.CouplePlan.AgeDifference.edit', compact('ageDifference', 'companies'));
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
            'company_id' => 'required',
            'product_id' => 'required',
            'age_difference' => 'required',
            'add_age' => 'required',
        ]);
        $ageDifference = CoupleAgeDifference::findOrFail($id);
        $ageDifference->update([
            'company_id' => $request->company_id,
            'product_id' => $request->product_id,
            'age_difference' => $request->age_difference,
            'add_age' => $request->add_age,
        ]);
        return redirect()->route('age-difference.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        $ageDifference = CoupleAgeDifference::findOrFail($id);
        $ageDifference->delete();
        return 'Deleted Successfully!';
    }
}
