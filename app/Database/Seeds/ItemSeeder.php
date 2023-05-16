<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'          => 'Gula',
                'description'   => 'karbohidrat sederhana yang menjadi sumber energi dan komoditi perdagangan utama.',
                'selling_price' => '11000',
                'purchase_price'=> '9000',
                'stock'         => 10,
                'unit'          => 'kg',
            ],
            [
                'name'          => 'Beras',
                'description'   => 'biji-bijian baik berkulit, tidak berkulit, diolah atau tidak diolah yang berasal dari Oriza Sativa.',
                'selling_price' => '15000',
                'purchase_price'=> '11000',
                'stock'         => 20,
                'unit'          => 'kg',
            ],
        ];
        $this->db->table('items')->insertBatch($data);
    }
}
