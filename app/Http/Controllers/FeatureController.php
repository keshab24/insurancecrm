<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductFeature;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feature = Feature::orderBy('created_at', 'desc')->get();
        return view('Feature.index', compact('feature'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('Feature.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        try {
            $product = new Feature;
            $product->name = $data['name'];
            $product->code = $data['code'];

            // dd($product);

            $product->save();
            return redirect('/featureList')->withSuccessMessage('Feature is added successfully.');
        } catch (Exception $e) {
            return back()->withInput()->withWarningMessage('Feature can not be created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature, $id)
    {
        $product = Feature::find($id);

        return view('Feature.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {
        $data = Feature::find($request->id);
        $data->name = $request['product_name'];
        $data->code = $request['code'];

        $data->save();
        return redirect('/featureList')->withSuccessMessage('Feature is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prodIds = ProductFeature::groupBy('feature_id')->pluck('feature_id')->toArray();
        $product = feature::find($id);
        if ($product && !in_array($id, $prodIds)) {
            $product->delete();
            return redirect()->back()->withSuccessMessage('Feature Deleted !');
        }
        return redirect()->back()->withErrors('Cannot delete feature | Used in Feature Product');
    }

    public function fpindex()
    {
        $feature = Feature::orderBy('created_at', 'desc')->get();
        return view('Feature.product.index', compact('feature'));
    }

    public function fpcreate()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        $features = Feature::orderBy('created_at', 'desc')->get();
        return view('Feature.product.create', compact('products', 'features'));
    }

    public function fpstore(Request $request)
    {
//        $validated = $request->validate([
//            'product_id' => 'unique:product_features',
//        ]);
        $data = $request->input();

        try {
            foreach ($request->product_id as $prod) {
                $product = ProductFeature::create([
                    "product_id" => $prod,
                    "feature_id" => $request->feature_id,
                ]);
            }
            return redirect('/featureproductList')->withSuccessMessage('Feature Products added successfully.');
        } catch (Exception $e) {
            return back()->withInput()->withWarningMessage('Feature product can not be created.');
        }
    }

    public function fpedit(Feature $feature, $id)
    {
        $feature = Feature::find($id);
        $products = Product::orderBy('created_at', 'desc')->get();;
        return view('Feature.product.edit', compact('feature', 'products'));
    }

    public function fpupdate(Request $request, $id)
    {
//        return $id;
//        return $request;
        $validated = $request->validate([
            'product_id' => 'required',
        ]);
        try {
            $dbProducts = ProductFeature::where('feature_id', $id)->pluck('product_id')->toArray();
            $rqProd = $request->product_id;
            $diffProd = array_diff($rqProd, $dbProducts);
            $delProd = array_diff($dbProducts, $rqProd);
            if ($delProd) {
                foreach ($delProd as $prod) {
                    ProductFeature::where('product_id', $prod)->where('feature_id', $id)->delete();
                }
            }
            $data = $request->input();

//           dd($request->compulsary_product);
            foreach ($rqProd as $prd) {
               $compulsary = in_array($prd,($request->compulsary_product)) ? 1 : 0;
                $pd = ProductFeature::where('product_id', $prd)->where('feature_id', $id)->update(["is_compulsory" => $compulsary]);
            }
            foreach ($diffProd as $prod) {
                $compulsary = in_array($prod,($request->compulsary_product)) ? 1 : 0;
                $product = ProductFeature::create([
                    "product_id" => $prod,
                    "feature_id" => $id,
                    "is_compulsory" => $compulsary
                ]);
            }
            return redirect('/featureproductList')->withSuccessMessage('Feature Products updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withWarningMessage('Feature product can not be updated. /' . $e->getMessage());
        }
    }

    public function fpdestroy(Feature $feature, $id)
    {
        try {
            ProductFeature::where('feature_id', $id)->delete();
            return redirect()->back()->withSuccess('Deleted Successfully !');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
//        $feature = Feature::find($id);
//        if (Feature::find($product)) {
//            $product->delete();
//        }
//        return redirect('featureproductList');
    }


}
