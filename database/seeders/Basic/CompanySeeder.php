<?php

namespace Database\Seeders\Basic;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Emptying the table
        DB::table('companies')->truncate();

        $company_type = ['new', 'old'];
        $product_type = ['life', 'non-life'];
        $product_category = ['endowment', 'pension', 'money-back', 'whole-life', 'term', 'retirement-pension', 'education', 'children', 'couple'];

        $companies = [

            // 1
            [
                'name' => 'Life Insurance Company',
                'code' => 'LIC',
                'type' => shuffle($company_type),
                'priority' => 1,
                'products' => [
                    [
                        'product_name' => 'Money Back',
                        'code' => rand(1, 999),
                        'type' => shuffle($product_type),
                        'category' => shuffle($product_category),
                    ],
                    [
                        'product_name' => 'Premium Life',
                        'code' => rand(1, 999),
                        'type' => shuffle($product_type),
                        'category' => shuffle($product_category),
                    ],
                    [
                        'product_name' => 'Whole Life',
                        'code' => rand(1, 999),
                        'type' => shuffle($product_type),
                        'category' => shuffle($product_category),
                    ],
                    [
                        'product_name' => 'Education',
                        'code' => rand(1, 999),
                        'type' => shuffle($product_type),
                        'category' => shuffle($product_category),
                    ],
                    [
                        'product_name' => 'Old Age Life',
                        'code' => rand(1, 999),
                        'type' => shuffle($product_type),
                        'category' => shuffle($product_category),
                    ],
                ]
            ],

            // 2
            // [
            //     'name' => 'National Life Insurance Company',
            //     'code' => 'NLIC',
            //     'type' => shuffle($company_type),
            //     'priority' => 2,
            //     'products' => [
            //         [
            //             'product_name' => 'Money Back',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Premium Life',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Whole Life',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Education',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Old Age Life',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //     ]
            // ],

            // // 3
            // [
            //     'name' => 'Asian Life Insurance Company',
            //     'code' => 'ALIC',
            //     'type' => shuffle($company_type),
            //     'priority' => 3,
            //     'products' => [
            //         [
            //             'product_name' => 'Money Back',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Premium Life',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Whole Life',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Education',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //         [
            //             'product_name' => 'Old Age Life',
            //             'code' => rand(1, 999),
            //             'type' => shuffle($product_type),
            //             'category' => shuffle($product_category),
            //         ],
            //     ]
            // ]

        ];

        foreach ($companies as $company) {

            $data = collect($company);

            // collect fields of  company
            $merge = $data->except('products');

            // create company
            $item = Company::create($merge->all());

            // create products of the company
            foreach ($data['products'] as $product) {
                $item->products()->create($product);
            }
        }
    }
}
