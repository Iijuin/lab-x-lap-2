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
                'description' => 'Kemampuan prosesor laptop',
                'weight' => 0.25
            ],
            [
                'name' => 'RAM',
                'description' => 'Kapasitas memori RAM',
                'weight' => 0.20
            ],
            [
                'name' => 'Storage',
                'description' => 'Kapasitas dan jenis penyimpanan',
                'weight' => 0.15
            ],
            [
                'name' => 'GPU',
                'description' => 'Kemampuan kartu grafis',
                'weight' => 0.20
            ],
            [
                'name' => 'Screen',
                'description' => 'Ukuran dan kualitas layar',
                'weight' => 0.10
            ],
            [
                'name' => 'Price',
                'description' => 'Harga laptop',
                'weight' => 0.10
            ]
        ];

        foreach ($criteria as $item) {
            Criteria::create($item);
        }
    }
}