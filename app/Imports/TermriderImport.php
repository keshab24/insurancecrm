<?php

namespace App\Imports;

use Auth;
use Carbon\Carbon;
use App\Models\Term;
use App\Models\User;
use App\Models\Policy_age;
use App\Models\Term_rider;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TermriderImport implements ToModel, WithHeadingRow
{
    protected $rateFile;

    public function __construct(array $rateFile)
    {
        $this->rateFile = $rateFile;
    }

    /**
     * @param array $row
     *
     * @return array
     */
    public function model(array $row)
    {
//        dd($this->rateFile);
        $datas = [];
        foreach ($row as $key => $val) {
            $record = [];
            $importedDta = [];
            $age = $row['ages_terms'];
            if ($key != 'ages_terms') {
                $record['age_id'] = Policy_age::where('age', $age)->first()->id;
                $record['term_id'] = Term::where('term', $key)->first()->id;
                $record['rate'] = $val;
                $record['company_id'] = $this->rateFile['company_id'];
                $record['product_id'] = $this->rateFile['product_id'];
                $oldData = Term_rider::where('age_id', $record['age_id'])
                    ->where('term_id', $record['term_id'])
                    ->where('company_id', $record['company_id'])
                    ->where('product_id', $record['product_id'])
                    ->pluck('id');
                if ($oldData) {
                    $aaa = Term_rider::whereIn('id', $oldData)->update(['deleted_at' => Carbon::now()]);
                }
                if ($record['rate'] > 0){
                $dta = Term_rider::create([
                    'age_id' => $record['age_id'],
                    'rate' => $record['rate'],
                    'term_id' => $record['term_id'],
                    'product_id' => $record['product_id'],
                    'company_id' => $record['company_id'],
                    'created_by' => Auth::user()->id,
                ]);
                array_push($datas, $record);
                array_push($importedDta, $dta);
            }
            }
        }
        return $importedDta;
    }

}

