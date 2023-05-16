<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class Hutang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'hutang' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'cicil' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'ENUM("cicil","lunas")',
                'null' => false,
                'default' => 'cicil'
            ],
            'created_at' => [
                'type' => 'DATE',
            ],
            'updated_at' => [
                'type' => 'DATE',
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('hutang', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('hutang');
    }
}
