<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PayingTerm;
use App\Models\Term;
use App\Models\WholeAdb;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayingTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $data['payingTerms'] = PayingTerm::all();
        return view('Backend.PayingTerm.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $companies = Company::select('id', 'name', 'is_active')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

//        dd($companies);

        foreach ($companies as $companyData) {
//            $companyData->products = $companyData->products;

            foreach ($companyData->products as $product) {
                // temp_rates is for temporary use
                $product->temp_rates = $product->rates;
                $arr = [];

                foreach ($product->temp_rates->unique('term_id') as $item) {
                    $arr[] = $item->term->term;
                }

                // setting terms
                $product->terms = $arr;

                //  removing unnecessary data
                unset($product->rates);
                unset($product->temp_rates);
            }
        }
        return view('Backend.PayingTerm.create', compact('companies'));
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
            'term' => 'required',
            'paying_year' => 'required',
        ]);

        $term_id = Term::where('term', $request->term)->first()->id;

        PayingTerm::create([
            'company_id' => $request->company_id,
            'product_id' => $request->product_id,
            'term_id' => $term_id,
            'paying_year' => $request->paying_year,
        ]);

        return redirect()->route('paying-term.index');
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
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        $payingTerm = PayingTerm::findOrFail($id);

        $payingTerm->delete();

        return 'Paying Term is deleted successfully.';
    }
}
