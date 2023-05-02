<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PaybackSchedule;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class PaybackScheduleController extends Controller
{
    public function index()
    {
        $product = Product::all();
        $companies = Company::all();
        $payback = PaybackSchedule::all();

        return view('paybackSchedule.view', compact('product', 'companies', 'payback'));
    }
    public function create()
    {
        $products = Product::all();
        $companies = Company::all();

        return view('paybackSchedule.create', compact('products', 'companies'));
    }
    public function store(Request $request)
    {
        $data = $request->input();
        // dd($data);
        try {

            $pay = new PaybackSchedule();
            $pay->term_year = $data['term_year'];
            $pay->payback_year = $data['payback_year'];
            $pay->rate = $data['rate'];
            $pay->company_id = $data['company_id'];
            $pay->product_id = $data['product_id'];
            if ($pay->payback_year <= $pay->term_year) {
                // dd($pay);
                # code...
                $pay->save();
                return redirect()->route('admin.payback.index');
            } else {
                # code...
                return back();
            }
        } catch (Exception $e) {
            return back()->with('failed', 'Failed to create Pay Back Schedule');
        }
    }
    public function edit(Request $request, $id)
    {
        $payback = PaybackSchedule::find($id);
        $product = Product::all();
        $companies = Company::all();
        return view('paybackSchedule.edit', compact('payback', 'product', 'companies'));
    }
    public function update(Request $request, $id)
    {
        $data = $request->input();
        try {
            $pay = PaybackSchedule::findorFail($id);
            $pay->term_year = $data['term_year'];
            $pay->payback_year = $data['payback_year'];
            $pay->rate = $data['rate'];
            $pay->company_id = $data['company_id'];
            $pay->product_id = $data['product_id'];
            $pay->save();
            return redirect()->route('admin.payback.index');
        } catch (Exception $e) {
            return back()->with('failed', 'Failed to create Pay Back Schedule');
        }
    }
    public function destroy($id)
    {
        $payback = PaybackSchedule::find($id);
        if ($payback) {
            $payback->delete();
        }
        return redirect()->route('admin.payback.index');
    }
}
