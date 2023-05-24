<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaction extends Migration
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
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'null' => TRUE
            ],
            'transaction_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'id_item' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'quantity' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'payment_type' => [
                'type' => 'ENUM("hutang", "tunai")',
                'null' => false,
                'default' => 'tunai',
            ],
            'total_price' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'cicil' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'ENUM("done","cicil")',
                'null' => false,
                'default' => 'cicil',
            ],
            'created_at' => [
                'type' => 'DATE',
            ],
            'updated_at' => [
                'type' => 'DATE',
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addKey('transaction_code');
        $this->forge->createTable('transactions', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
