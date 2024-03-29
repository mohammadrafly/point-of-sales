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
        'cicil',
        'user_id',
        'id_item',
        'transaction_code',
        'quantity',
        'payment_type',
        'total_price',
        'status',
        'created_at',
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
        try {
            $query = $this->db->table('transactions')
                ->select('
                    transactions.*,
                    users.name as nama_user,
                    items.name,
                    items.selling_price,
                    items.unit
                ')
                ->join('items', 'transactions.id_item = items.id')
                ->join('users', 'transactions.user_id = users.id', 'left')
                ->where('transaction_code', $transactionCode);
    
            $result = $query->get()->getResultArray();
    
            if ($result && $result[0]['user_id'] === null) {
                foreach ($result as &$row) {
                    unset($row['nama_user']);
                }
            }
    
            return $result;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    

    function joinTransactionsWithUsersByPaymentType($type)
    {
        return $this->db->table('transactions')
            ->select('
                transactions.*,
                users.name as nama_user,
                users.address as alamat_user,
                users.phone_number as nomor_user
            ')
            ->join('users', 'transactions.user_id = users.id')
            ->where('payment_type', $type)
            ->get()->getResultArray();
    }

    public function getTotalByTransactionCode($transactionCode)
    {
        return $this->db->table('transactions')
                    ->where('transaction_code', $transactionCode)
                    ->selectSum('total_price')
                    ->get()
                    ->getRowArray()['total_price'];
    }

    public function RangeDate($start, $end, $payment, $status = '')
    {
        $query = $this->db->table('transactions')
            ->select('
                transactions.*,
                transactions.created_at as waktu_transaksi
            ')
            ->where('transactions.created_at BETWEEN "'. date('Y-m-d', strtotime($start)). '" AND "'. date('Y-m-d', strtotime($end)).'"');
    
        if ($payment !== 'tunai') {
            $query->join('users', 'transactions.user_id = users.id')
                  ->select('users.name as nama_user');
        }
    
        $query->where('transactions.payment_type', $payment);
    
        if ($status !== '') {
            $query->where('transactions.status', $status);
        }
    
        $query->orderBy('transactions.created_at', 'DESC');
    
        $result = $query->get()->getResult();
        return $result;
    }
}
