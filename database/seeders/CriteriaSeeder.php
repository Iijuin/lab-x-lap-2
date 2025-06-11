<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            [
                'name' => 'Processor',
                'code' => 'processor',
                'description' => 'Kemampuan prosesor laptop',
                'priority_rank' => 1,
                'weight' => 0.25
            ],
            [
                'name' => 'RAM',
                'code' => 'ram',
                'description' => 'Kapasitas memori RAM',
                'priority_rank' => 2,
                'weight' => 0.20
            ],
            [
                'name' => 'Storage',
                'code' => 'storage',
                'description' => 'Kapasitas dan jenis penyimpanan',
                'priority_rank' => 3,
                'weight' => 0.15
            ],
            [
                'name' => 'GPU',
                'code' => 'gpu',
                'description' => 'Kemampuan kartu grafis',
                'priority_rank' => 4,
                'weight' => 0.20
            ],
            [
                'name' => 'Screen',
                'code' => 'screen',
                'description' => 'Ukuran dan kualitas layar',
                'priority_rank' => 5,
                'weight' => 0.10
            ],
            [
                'name' => 'Price',
                'code' => 'price',
                'description' => 'Harga laptop',
                'priority_rank' => 6,
                'weight' => 0.10
            ]
        ];

        foreach ($criteria as $item) {
            Criteria::create($item);
        }
    }
}