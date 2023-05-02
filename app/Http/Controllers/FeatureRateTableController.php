<?php

namespace App\Http\Controllers;

use Auth;
use Response;


use Exception;
use App\Models\Term;
use App\Models\Company;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Pwb_rate;
use App\Models\WholeAdb;
use App\Models\RateTable;
use App\Imports\PwbImport;
use App\Models\Policy_age;
use App\Models\Term_rider;
use Illuminate\Http\Request;
use App\Models\ProductFeature;
use App\Models\Rate_endowment;
use App\Imports\WholeAdbImport;
use App\Imports\TermriderImport;
use App\Imports\FeatureRateImport;
use App\Exports\CompanyRatesExport;
use App\Models\ProductFeatureRates;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EndowmwntRatesExport;
use App\Imports\EndowmentRatesImport;
use App\Exports\CompanyadbRatesExport;
use App\Exports\CompanypwbRatesExport;
use App\Exports\CompanytermRatesExport;
use App\Exports\CompanyfeatureRatesExport;

class FeatureRateTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function featurerate(Request $request)
    {
        $data['companies'] = Company::all();
        $data['policyages'] = Policy_age::all();
        $data['terms'] = Term::all();
        $data['products'] = Product::all();
        $data['features'] = Feature::all();
        $rows = [];
            $columns = [];
            
        if (isset($request->feature_id)) {
            $data['selectedCompany'] = Feature::where('id', $request->feature_id)->first();
            $data['selectedProduct'] = Product::where('id', $request->product_id)->first();

            $prodFtId = ProductFeature::where('product_id',$request->product_id)->where('feature_id',$request->feature_id)->first()->id;
            $record['product_feature_id'] = $prodFtId;

            $data['rateEndowments'] = ProductFeatureRates::where('product_feature_id', $prodFtId)

            ->orderBy('age_id')
            ->orderBy('term_id')
            ->select('id', 'rate', 'age_id', 'term_id')
            ->get();
          

            
            foreach ($data['rateEndowments'] as $index => $record) {
                // Create an empty array if the key does not exist yet
                if (!isset($rows[$record->age->age])) {
                    $rows[$record->age->age] = [];
                }

                // Add the column to the array of columns if it's not yet in there
                if (!in_array($record->term->term, $columns)) {
                    $columns[] = $record->term->term;
                }

                // Add the rate to the 2 dimensional array
                $rows[$record->age->age][$record->term->term] = [$record->rate, $record->id];
            }
            $columns = collect($columns)->sort()->values()->all();
            //            return $rows;
        }
        $companies = Company::all();
        return view('RateTable.featurerate.index', $data, compact('rows', 'columns'));
    }

    public function importfeature(Request $request)
    {
        try {
            if ($request->hasFile('bulk_file')) {
                $rateFile = new FeatureRateImport([
                    'feature_id' => $request->feature_id,
                    'product_id' => $request->product_id,
                ]);
                Excel::import($rateFile, request()->file('bulk_file'));
            }
            //            Excel::import(new EndowmwntRatesImport, 'users.xlsx');

            return redirect()->back()->with('success_message', 'Rates Imported Successfully!');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function exportfeatureData(Request $request)
    {
        
        try {
            $export = new CompanyfeatureRatesExport([
                'feature_id' => $request->feature_id,
                'product_id' => $request->product_id,
            ]);
            return Excel::download($export, 'productFeatureRates.xlsx');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updatefeatureRateEndowment(Request $request)
    {
            //    return $request;
        try {
            if ($request->pk == "add") {
                $dta = explode(',', $request->name);
                $data = new ProductFeatureRates;
                $data->rate = $request->value;
                $data->age_id = Policy_age::where('age', $dta[0])->first()->id;
                $data->term_id = Term::where('term', $dta[1])->first()->id;

                $prodFtId = ProductFeature::where('product_id',$dta[3])->where('feature_id', $dta[2])->first()->id;

                $data->product_feature_id = $prodFtId;
               
               
                $data->save();
                return Response::json(array('success' => true, $data));
            } else {
                $data = ProductFeatureRates::find($request->pk);
                $data->rate = $request->value;
                $data->save();
                return Response::json(array('success' => true, $data));
            }
        } catch (Exception $e) {
            return Response::json(array('success' => false, $e->getMessage()));
        }
    }


}
