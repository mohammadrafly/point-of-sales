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
        //dd($model->getDetails('TRX-fe385986bccb619d79709b5bfb4ded3f'));
        $data = [
            'content' => $model->joinTransactionsWithUsers(),
        ];
        return view('pages/dashboard/list_transaction', $data);
    }

    public function bayarHutang($transactionCode)
    {
        $model = new Transactions();
        $data = [
            'status' => 'done',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $model->where('transaction_code', $transactionCode)->set($data)->update();
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil melakukan pembayaran',
        ]);
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
