<?php

namespace App\Models;

use CodeIgniter\Model;

class Hutang extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'hutang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_hutang',
        'supplier',
        'hutang',
        'cicil',
        'status',
        'created_at',
        'updated_at',
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

    public function RangeDate($start, $end, $status = '')
    {
        $query = $this->db->table('hutang')
                ->where('created_at BETWEEN "'. date('Y-m-d', strtotime($start)). '" AND "'. date('Y-m-d', strtotime($end)).'"');
    
        if ($status !== '') {
            $query->where('status', $status);
        }
    
        $query->orderBy('created_at', 'DESC');
        
        $result = $query->get()->getResult();
        return $result;
    }    
}
