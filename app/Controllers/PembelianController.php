<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Items;
use App\Models\Pembelian;

class PembelianController extends BaseController
{
    public function index($kode_barang)
    {
        helper('number');
        $model = new Pembelian();
        $modelItem = new Items();
        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->where('kode_barang', $kode_barang)->findAll(),
                'kode_barang' => $kode_barang,
            ];
            return view('pages/dashboard/pembelian', $data);
        }

        $data = [
            'kode_barang' => $this->request->getPost('kode_barang'),
            'purchase_price' => $this->request->getPost('purchase_price'),
            'stock' => $this->request->getPost('stock'),
        ];
        
        $checkBarang = $modelItem->where('kode_barang', $data['kode_barang'])->first();
        $totalStock = $checkBarang['stock'] + $data['stock'];
        if ($model->insert($data)) {
            if ($modelItem->update($checkBarang['id'],[
                'purchase_price' => $data['purchase_price'],
                'stock' => $totalStock,
            ])) {
                return $this->response->setJSON([
                    'success' => TRUE,
                    'message' => 'Berhasil melakukan pembelian barang'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => FALSE,
                    'message' => 'Gagal melakukan pembelian barang'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal melakukan pembelian barang'
            ]);
        }
    }

    public function detail($id)
    {
        $model = new Pembelian();
        return $this->response->setJSON([
            'data' => $model->find($id)
        ]);
    }

    public function delete($id = null) 
    {
        $model = new Pembelian();
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