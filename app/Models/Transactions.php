<?php

namespace App\Models;

use CodeIgniter\Model;

class Transactions extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'id_item',
        'transaction_code',
        'quantity',
        'payment_type',
        'total_price',
        'status',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function getDetails($transactionCode)
    {
        return $this->db->table('transactions')
            ->select('
                transactions.*,
                users.name as nama_user,
                items.name,
                items.selling_price,
                items.unit
            ')
            ->join('items', 'transactions.id_item = items.id')
            ->join('users', 'transactions.user_id = users.id')
            ->where('transaction_code', $transactionCode)
            ->get()->getResultArray();
    }

    function joinTransactionsWithUsers()
    {
        return $this->db->table('transactions')
            ->select('
                transactions.*,
                users.name as nama_user,
            ')
            ->join('users', 'transactions.user_id = users.id')
            ->get()->getResultArray();
    }
}
