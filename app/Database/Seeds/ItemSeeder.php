<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $randomNumber = mt_rand(100000000, 999999999) . uniqid();
        $randomNumber = substr($randomNumber, 0, 10);
        $prefix = 'KB'.$randomNumber;

        $data = [
            [
                'kode_barang'   => $prefix,
                'name'          => 'Gula',
                'description'   => 'karbohidrat sederhana yang menjadi sumber energi dan komoditi perdagangan utama.',
                'selling_price' => '11000',
                'purchase_price'=> '9000',
                'stock'         => 10,
                'unit'          => 'KG',
            ],
            [
                'kode_barang'   => $prefix,
                'name'          => 'Beras',
                'description'   => 'biji-bijian baik berkulit, tidak berkulit, diolah atau tidak diolah yang berasal dari Oriza Sativa.',
                'selling_price' => '15000',
                'purchase_price'=> '11000',
                'stock'         => 20,
                'unit'          => 'KG',
            ],
        ];
        $this->db->table('items')->insertBatch($data);
    }
}
