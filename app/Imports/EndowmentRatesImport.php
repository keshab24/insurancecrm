<?php

namespace App\Imports;

use App\Models\Policy_age;
use App\Models\Term;
use App\Models\Rate_endowment;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;

class EndowmentRatesImport implements ToModel, WithHeadingRow
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
//        dd($row);
        $datas = [];
        foreach ($row as $key => $val) {
            $record = [];
            $importedDta = [];
            $age = $row['ages_terms'];
            if ($key != 'ages_terms' && $age && $key) {
                $record['age_id'] = Policy_age::where('age', $age)->first()->id;
                $record['term_id'] = Term::where('term', $key)->first()->id;
                $record['rate'] = $val;
                $record['company_id'] = $this->rateFile['company_id'];
                $record['product_id'] = $this->rateFile['product_id'];
                $oldData = Rate_endowment::where('age_id', $record['age_id'])
                    ->where('term_id', $record['term_id'])
                    ->where('company_id', $record['company_id'])
                    ->where('product_id', $record['product_id'])
                    ->pluck('id');
                if ($oldData) {
                    $aaa = Rate_endowment::whereIn('id', $oldData)->update(['deleted_at' => Carbon::now()]);
                }
//                dd($age);
                if ($record['rate'] > 0){
                $dta = Rate_endowment::create([
                    'age_id' => $record['age_id'],
                    'rate' => $record['rate'] ? floatval($record['rate']) : '0',
                    'term_id' => $record['term_id'],
                    'product_id' => $record['product_id'],
                    'company_id' => $record['company_id'],
                    'created_by' => Auth::user()->id,
                ]);
//                array_push($datas, $record);
                array_push($importedDta, $dta);
//                dd($importedDta);
            }
            }
        }
//        dd($importedDta);
        return $importedDta;
    }

}
