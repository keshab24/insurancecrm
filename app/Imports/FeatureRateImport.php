<?php

namespace App\Imports;

use Auth;
use Carbon\Carbon;
use App\Models\Term;
use App\Models\User;
use App\Models\Pwb_rate;
use App\Models\Policy_age;
use Illuminate\Support\Str;
use App\Models\ProductFeature;
use App\Models\ProductFeatureRates;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FeatureRateImport implements ToModel, WithHeadingRow
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
    //    dd($this->rateFile);
        $datas = [];
        foreach ($row as $key => $val) {
            $record = [];
            $importedDta = [];
            $age = $row['ages_terms'];
            
            if ($key != 'ages_terms') {
                $record['age_id'] = Policy_age::where('age', $age)->first()->id;
                $record['term_id'] = Term::where('term', $key)->first()->id;
                $record['rate'] = $val;
                $prodFtId = ProductFeature::where('product_id',$this->rateFile['product_id'])->where('feature_id',$this->rateFile['feature_id'])->first()->id;
                $record['product_feature_id'] = $prodFtId;
               
                $oldData = ProductFeatureRates::where('age_id', $record['age_id'])
                    ->where('term_id', $record['term_id'])
                    ->where('product_feature_id', $record['product_feature_id'])
                    ->pluck('id');

                if ($oldData) {
                    $aaa = ProductFeatureRates::whereIn('id', $oldData)->update(['deleted_at' => Carbon::now()]);
                }
                if ($record['rate'] > 0){
                $dta = ProductFeatureRates::create([
                    'age_id' => $record['age_id'],
                    'rate' => $record['rate'],
                    'term_id' => $record['term_id'],
                    'product_feature_id' => $prodFtId,
                    
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

