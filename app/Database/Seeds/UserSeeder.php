<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email'    => 'admin@gmail.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'name'     => 'admin',
                'phone_number' => '0810000000',
                'address'  => 'Jl. Kenangan',
            ],
            [
                'username' => 'kasir',
                'email'    => 'kasir@gmail.com',
                'password' => password_hash('kasir', PASSWORD_DEFAULT),
                'role'     => 'kasir',
                'name'     => 'kasir',
                'phone_number' => '0810000000',
                'address'  => 'Jl. Kenangan',
            ],
            [
                'username' => 'customer',
                'email'    => 'customer@gmail.com',
                'password' => password_hash('customer', PASSWORD_DEFAULT),
                'role'     => 'customer',
                'name'     => 'customer',
                'phone_number' => '0810000000',
                'address'  => 'Jl. Kenangan',
            ],

        ];
        $this->db->table('users')->insertBatch($data);
    }
}
