<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    public function run()
    {
        $criteria = [
            [
                'name' => 'Processor',
                'code' => 'processor',
                'description' => 'Kecepatan dan performa CPU laptop',
                'priority_rank' => 1,
                'relative_importance' => 1.00,
                'type' => 'benefit',
                'is_active' => true
            ],
            [
                'name' => 'RAM',
                'code' => 'ram',
                'description' => 'Kapasitas memori RAM',
                'priority_rank' => 2,
                'relative_importance' => 0.80,
                'type' => 'benefit',
                'is_active' => true
            ],
            [
                'name' => 'Storage',
                'code' => 'storage',
                'description' => 'Kapasitas dan jenis penyimpanan',
                'priority_rank' => 3,
                'relative_importance' => 0.60,
                'type' => 'benefit',
                'is_active' => true
            ],
            [
                'name' => 'GPU',
                'code' => 'gpu',
                'description' => 'Kartu grafis untuk gaming dan desain',
                'priority_rank' => 4,
                'relative_importance' => 0.70,
                'type' => 'benefit',
                'is_active' => true
            ],
            [
                'name' => 'Screen Size',
                'code' => 'screen',
                'description' => 'Ukuran dan kualitas layar',
                'priority_rank' => 5,
                'relative_importance' => 0.40,
                'type' => 'benefit',
                'is_active' => true
            ],
            [
                'name' => 'Price',
                'code' => 'price',
                'description' => 'Harga laptop',
                'priority_rank' => 6,
                'relative_importance' => 0.50,
                'type' => 'cost',
                'is_active' => true
            ]
        ];

        foreach ($criteria as $criteriaData) {
            Criteria::create($criteriaData);
        }

        // Calculate SWARA weights after seeding
        Criteria::calculateSwaraWeights();
    }
}