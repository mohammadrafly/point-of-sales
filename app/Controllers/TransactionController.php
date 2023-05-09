<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Items;
use App\Models\Transactions;

class TransactionController extends BaseController
{
    public function index()
    {
        $model = new Transactions();
        $modelItems = new Items();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->findAll(),
                'barang' => $modelItems->findAll(),
            ];
            return view('pages/dashboard/transaction', $data);
        }

       
        $transactions = []; // Array to store all the transaction data

        $id_items = $this->request->getPost('name[]'); // Get all id_item values
        $quantities = $this->request->getPost('quantity[]'); // Get all quantity values
        $total_prices = $this->request->getPost('total_price[]'); // Get all total_price values

        $transactionCode = 'TRX-' . bin2hex(random_bytes(16));
        // Loop through all the values and create an array for each transaction
        for ($i = 0; $i < count($id_items); $i++) {
            $transaction = [
                'id_item' => $id_items[$i],
                'quantity' => $quantities[$i],
                'payment_type' => $this->request->getPost('payment_type'),
                'transaction_code' => $transactionCode,
                'total_price' => $total_prices[$i],
                'status' => 'no_payment'
            ];
            $transactions[] = $transaction; // Add the transaction to the array
        }
        
        if ($model->insertBatch($transactions)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil melakukan transaksi'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal melakukan transaksi'
            ]);
        }
    }

    public function update($id = null)
    {
        $model = new Transactions();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->where('id', $id)->first()
            ];

            return view('pages/dashboard/transactionUpdate', $data);
        }

        $data = [
            'id_item' => $this->request->getVar('id_item'),
            'quantity' => $this->request->getVar('quantity'),
            'payment_type' => $this->request->getVar('payment_type'),
            'status' => $this->request->getVar('status'),
            'updated_at' => date('H:i:s Y-m-d'),
        ];
        
        if ($model->update($id, $data)) {
            return redirect()->to('dashboard/transaction')->with('success', 'Berhasil update data transaksi');
        } else {
            return redirect()->to('dashboard/transaction')->with('error', 'Gagal update data transaksi');
        }
    }

    public function delete($id = null) 
    {
        $model = new Transactions();
        if ($model->where('id', $id)->delete($id)) {
            return redirect()->to('dashboard/transaction')->with('success', 'Berhasil hapus data barang');
        } else {
            return redirect()->to('dashboard/transaction')->with('error', 'Gagal hapus data barang');
        }
    }
}
