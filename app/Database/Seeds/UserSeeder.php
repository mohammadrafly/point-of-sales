<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'role'     => 'admin',
            'name'     => 'admin',
            'phone_number' => '0810000000',
            'address'  => 'Jl. Kenangan',
        ];

        $this->db->query('INSERT INTO users (username, email, password, role, name, phone_number, address) VALUES(:username:, :email:, :password:, :role:, :name:, :phone_number:, :address:)', $data);
        $this->db->table('users')->insert($data);
    }
}
