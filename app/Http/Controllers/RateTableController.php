<?php

namespace App\Http\Controllers;

use Auth;
use Response;
use Exception;
use App\Models\Term;
use App\Models\Company;
use App\Models\Product;
use App\Models\Pwb_rate;
use App\Models\WholeAdb;
use App\Models\RateTable;
use App\Imports\PwbImport;
use App\Models\Policy_age;
use App\Models\Term_rider;
use Illuminate\Http\Request;
use App\Models\Rate_endowment;
use App\Imports\WholeAdbImport;
use App\Imports\TermriderImport;
use App\Exports\CompanyRatesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EndowmwntRatesExport;
use App\Imports\EndowmentRatesImport;
use App\Exports\CompanyadbRatesExport;
use App\Exports\CompanypwbRatesExport;
use App\Exports\CompanytermRatesExport;

class RateTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function export()
    {
        return Excel::download(new EndowmwntRatesExport, 'endowmentRates.xlsx');
    }

    public function exportData(Request $request)
    {
        try {
            $export = new CompanyRatesExport([
                'company_id' => $request->company_id,
                'product_id' => $request->product_id,
            ]);
            return Excel::download($export, 'companyEndowmentRates.xlsx');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function importEndowment(Request $request)
    {
        try {
            if ($request->hasFile('bulk_file')) {
                $rateFile = new EndowmentRatesImport([
                    'company_id' => $request->company_id,
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

    public function endowmentRate(Request $request)
    {
        $data['companies'] = Company::all();
        $data['policyages'] = Policy_age::all();
        $data['terms'] = Term::all();
        $data['products'] = Product::all();
        if ($request) {
            $data['selectedCompany'] = Company::where('id', $request->company_id)->first();
            $data['selectedProduct'] = Product::where('id', $request->product_id)->first();
            $data['rateEndowments'] = Rate_endowment::where('company_id', $request->company_id)
                ->where('product_id', $request->product_id)
                ->orderBy('age_id')
                ->orderBy('term_id')
                ->select('id', 'rate', 'age_id', 'term_id')
                ->get();

            $rows = [];
            $columns = [];
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
        return view('RateTable.EndowmentRate.index', $data, compact('rows', 'columns'));
    }

    public function allEndowmentRate(Request $request)
    {
        $data['rateEndowments'] = Rate_endowment::all();
        return Response::json(array('success' => true, $data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RateTable $rateTable
     * @return \Illuminate\Http\Response
     */


    public function updateRateEndowment(Request $request)
    {
        //        return $request;
        try {
            if ($request->pk == "add") {
                $dta = explode(',', $request->name);
                $data = new Rate_endowment;
                $data->rate = $request->value;
                $data->age_id = Policy_age::where('age', $dta[0])->first()->id;
                $data->term_id = Term::where('term', $dta[1])->first()->id;
                $data->company_id = $dta[2];
                $data->product_id = $dta[3];
                $data->created_by = Auth::user()->id;
                $data->save();
                return Response::json(array('success' => true, $data));
            } else {
                $data = Rate_endowment::find($request->pk);
                $data->rate = $request->value;
                $data->save();
                return Response::json(array('success' => true, $data));
            }
        } catch (Exception $e) {
            return Response::json(array('success' => false, $e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\RateTable $rateTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(RateTable $rateTable)
    {
        //
    }


    public function termrider(Request $request)
    {
        $data['companies'] = Company::all();
        $data['policyages'] = Policy_age::all();
        $data['terms'] = Term::all();
        $data['products'] = Product::all();
        if ($request) {
            $data['selectedCompany'] = Company::where('id', $request->company_id)->first();
            $data['selectedProduct'] = Product::where('id', $request->product_id)->first();
            $data['rateEndowments'] = Term_rider::where('company_id', $request->company_id)
                ->where('product_id', $request->product_id)
                ->orderBy('age_id')
                ->orderBy('term_id')
                ->select('id', 'rate', 'age_id', 'term_id')
                ->get();

            $rows = [];
            $columns = [];
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
        return view('RateTable.term_rider.index', $data, compact('rows', 'columns'));
    }

    public function exporttermData(Request $request)
    {
        try {
            $export = new CompanytermRatesExport([
                'company_id' => $request->company_id,
                'product_id' => $request->product_id,
            ]);
            return Excel::download($export, 'companyEndowmentRates.xlsx');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function importterm(Request $request)
    {
        try {
            if ($request->hasFile('bulk_file')) {
                $rateFile = new TermriderImport([
                    'company_id' => $request->company_id,
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

    public function updateRateTerm(Request $request)
    {
        //        return $request;
        try {
            if ($request->pk == "add") {
                $dta = explode(',', $request->name);
                $data = new Term_rider;
                $data->rate = $request->value;
                $data->age_id = Policy_age::where('age', $dta[0])->first()->id;
                $data->term_id = Term::where('term', $dta[1])->first()->id;
                $data->company_id = $dta[2];
                $data->product_id = $dta[3];
                $data->created_by = Auth::user()->id;
                $data->save();
                return Response::json(array('success' => true, $data));
            } else {
                $data = Term_rider::find($request->pk);
                $data->rate = $request->value;
                $data->save();
                return Response::json(array('success' => true, $data));
            }
        } catch (Exception $e) {
            return Response::json(array('success' => false, $e->getMessage()));
        }
    }

    public function wholeadb(Request $request)
    {
        $data['companies'] = Company::all();
        $data['policyages'] = Policy_age::all();
        $data['terms'] = Term::all();
        $data['products'] = Product::all();
        if ($request) {
            $data['selectedCompany'] = Company::where('id', $request->company_id)->first();
            $data['selectedProduct'] = Product::where('id', $request->product_id)->first();
            $data['type'] = $request->type;
            
            $data['rateEndowments'] = WholeAdb::where('company_id', $request->company_id)
                ->where('product_id', $request->product_id)
               
                ->orderBy('age_id')
                ->orderBy('term_id')
                ->select('id', 'rate', 'age_id', 'term_id')
                ->get();

            $rows = [];
            $columns = [];
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
        return view('RateTable.whole_adb.index', $data, compact('rows', 'columns'));
    }


    public function exportadbData(Request $request)
    {
        try {
            $export = new CompanyadbRatesExport([
                'company_id' => $request->company_id,
                'product_id' => $request->product_id,
            ]);
            return Excel::download($export, 'companyEndowmentRates.xlsx');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function importadb(Request $request)
    {
        try {
            if ($request->hasFile('bulk_file')) {
                $rateFile = new WholeAdbImport([
                    'company_id' => $request->company_id,
                    'product_id' => $request->product_id,
                    'type' => $request->type,
                ]);
                Excel::import($rateFile, request()->file('bulk_file'));
            }
            //            Excel::import(new EndowmwntRatesImport, 'users.xlsx');

            return redirect()->back()->with('success_message', 'Rates Imported Successfully!');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function wholeRateTerm(Request $request)
    {
        //        return $request;
        try {
            if ($request->pk == "add") {
                $dta = explode(',', $request->name);
                $data = new WholeAdb;
                $data->rate = $request->value;
                $data->age_id = Policy_age::where('age', $dta[0])->first()->id;
                $data->term_id = Term::where('term', $dta[1])->first()->id;
                $data->company_id = $dta[2];
                $data->product_id = $dta[3];
                $data->created_by = Auth::user()->id;
                $data->type = $request->type;
                $data->save();
                return Response::json(array('success' => true, $data));
            } else {
                $data = WholeAdb::find($request->pk);
                $data->rate = $request->value;
                $data->save();
                return Response::json(array('success' => true, $data));
            }
        } catch (Exception $e) {
            return Response::json(array('success' => false, $e->getMessage()));
        }
    }


    public function pwbrate(Request $request)
    {
        $data['companies'] = Company::all();
        $data['policyages'] = Policy_age::all();
        $data['terms'] = Term::all();
        $data['products'] = Product::all();
        if ($request) {
            $data['selectedCompany'] = Company::where('id', $request->company_id)->first();
            $data['selectedProduct'] = Product::where('id', $request->product_id)->first();
            $data['rateEndowments'] = Pwb_rate::where('company_id', $request->company_id)
                ->where('product_id', $request->product_id)
                ->orderBy('age_id')
                ->orderBy('term_id')
                ->select('id', 'rate', 'age_id', 'term_id')
                ->get();

            $rows = [];
            $columns = [];
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
        return view('RateTable.pwb_rate.index', $data, compact('rows', 'columns'));
    }

    public function importpwb(Request $request)
    {
        try {
            if ($request->hasFile('bulk_file')) {
                $rateFile = new PwbImport([
                    'company_id' => $request->company_id,
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

    public function pwbRateTerm(Request $request)
    {
        //        return $request;
        try {
            if ($request->pk == "add") {
                $dta = explode(',', $request->name);
                $data = new Pwb_rate;
                $data->rate = $request->value;
                $data->age_id = Policy_age::where('age', $dta[0])->first()->id;
                $data->term_id = Term::where('term', $dta[1])->first()->id;
                $data->company_id = $dta[2];
                $data->product_id = $dta[3];
                $data->created_by = Auth::user()->id;
                $data->save();
                return Response::json(array('success' => true, $data));
            } else {
                $data = Pwb_rate::find($request->pk);
                $data->rate = $request->value;
                $data->save();
                return Response::json(array('success' => true, $data));
            }
        } catch (Exception $e) {
            return Response::json(array('success' => false, $e->getMessage()));
        }
    }





    public function exportpwbData(Request $request)
    {
        try {
            $export = new CompanypwbRatesExport([
                'company_id' => $request->company_id,
                'product_id' => $request->product_id,
            ]);
            return Excel::download($export, 'companyEndowmentRates.xlsx');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
