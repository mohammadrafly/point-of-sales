<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Items;

class ItemController extends BaseController
{
    public function index()
    {
        helper('number');
        $model = new Items();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->findAll(),
            ];
            return view('pages/dashboard/item', $data);
        }

        $randomNumber = mt_rand(100000000, 999999999) . uniqid();
        $randomNumber = substr($randomNumber, 0, 10);
        $prefix = 'KB'.$randomNumber;

        $data = [
            'kode_barang' => $prefix,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'selling_price' => $this->request->getPost('selling_price'),
            'purchase_price' => $this->request->getPost('purchase_price'),
            'stock' => $this->request->getPost('stock'),
            'unit' => $this->request->getPost('unit'),
        ];
        
        if ($model->insert($data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data barang'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data barang'
            ]);
        }
    }

    public function update($id)
    {
        $model = new Items();

        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON([
                'success' => TRUE,
                'data' => $model->where('id', $id)->first(),
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'selling_price' => $this->request->getPost('selling_price'),
            'purchase_price' => $this->request->getPost('purchase_price'),
            'stock' => $this->request->getPost('stock'),
            'unit' => $this->request->getPost('unit'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil update data barang'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal update data barang'
            ]);
        }
    }

    public function delete($id = null) 
    {
        $model = new Items();
        if ($model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil hapus data barang'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal hapus data barang'
            ]);
        }
    }
}
