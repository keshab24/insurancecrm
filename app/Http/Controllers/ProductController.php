<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $product = Product::orderBy('created_at', 'desc')->get();
        return view('Product.productList', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('Product.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        try {
            Product::create($request->all());
            return redirect('productList')->withSuccessMessage('Product is added successfully.');
        } catch (Exception $e) {
            return back()->withInput()->withWarningMessage('Product can not be created.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $companies = Company::all();
        return view('Product.edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($request->id);
            $product->update($request->all());

            return redirect('productList')->withSuccessMessage('Product is updated successfully.');
        } catch (Exception $e) {
            return back()->withInput()->withWarningMessage('Product can not be updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (Product::find($product)) {
            $product->delete();
        }
        return redirect('productList')->withSuccessMessage('Product is deleted successfully can be restored if needed');
    }

    public function updateProductStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->back();
    }
}
