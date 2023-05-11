<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
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
                'type' => 'INT',
                'constraint' => 11,
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
            'status' => [
                'type' => 'ENUM("done","half","no_payment")',
                'null' => false,
                'default' => 'no_payment',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('transactions', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
