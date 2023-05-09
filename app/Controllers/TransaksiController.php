<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transactions;

class TransaksiController extends BaseController
{
    public function index()
    {
        helper('number');
        $model = new Transactions();
        $data = [
            'content' => $model->findAll(),
        ];
        return view('pages/dashboard/list_transaction', $data);
    }

    public function update($transactionCode)
    {
  
    }

    public function details($transactionCode)
    {
        $model = new Transactions();
        return $this->response->setJSON([
            'success' => true,
            'data' => $model->getDetails($transactionCode),
        ]);   
    }
}
