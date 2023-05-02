<?php

namespace App\Exports;

use App\Models\Rate_endowment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EndowmwntRatesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Rate_endowment::select('rate','age_id','term_id','product_id','company_id','premium_paying_terms')->get();
    }

    public function headings(): array
    {
        return [
            'rate',
            'age_id',
            'term_id',
            'product_id',
            'company_id',
            'premium_paying terms',
        ];
    }
}
