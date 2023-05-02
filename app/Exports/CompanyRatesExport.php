<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Product;
use App\Models\Rate_endowment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyRatesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $export;

    public function __construct(array $export)
    {
        $this->export = $export;
    }
    public function view():view
    {
//        dd($this->export);
        $selectedCompany = Company::where('id', $this->export['company_id'])->first();
        $selectedProduct = Product::where('id', $this->export['product_id'])->first();
        $data['rateEndowments'] = Rate_endowment::where('company_id', $this->export['company_id'])
            ->where('product_id', $this->export['product_id'])
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
        return view('RateTable.EndowmentRate.extract-table', [
            'rows' => $rows,
            'columns' => $columns,
            'selectedCompany' => $selectedCompany,
            'selectedProduct' => $selectedProduct,
        ]);
    }
}
