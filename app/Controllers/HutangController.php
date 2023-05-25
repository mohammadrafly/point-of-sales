<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Hutang;
use App\Models\Items;
use App\Models\Users;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HutangController extends BaseController
{
    public function index()
    {
        helper('number');
        $model = new Hutang();
        $modelUser = new Users();
        $modelItem = new Items();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->findAll(),
                'user' => $modelUser->where('role', 'supplier')->findAll(),
            ];
            return view('pages/dashboard/hutang', $data);
        }

        $currentDate = date('Y-m-d');
        $nextDay = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        $names = $this->request->getVar('name[]');
        $purchasePrices = $this->request->getVar('purchase_price[]');
        $units = $this->request->getVar('unit[]');
        $quantities = $this->request->getVar('quantity[]');
        $hutangCode = 'HTG-' . bin2hex(random_bytes(16));

        $regularNumbers = array_map(function($price) {
            $number = str_replace(["Rp ", ".", ","], "", $price);
            return (float) $number;
        }, $purchasePrices);

        $total = array_sum($regularNumbers);

        if (count($regularNumbers) === count($quantities)) {
            $result = [];
        
            for ($i = 0; $i < count($regularNumbers); $i++) {
                $result[] = $regularNumbers[$i] / $quantities[$i];
            }
        }

        $data = [
            'kode_hutang' => $hutangCode,
            'supplier' => $this->request->getVar('supplier'),
            'hutang' => $total,
            'cicil' => '0',
            'status' => 'cicil',
            'created_at' => $nextDay,
            'updated_at' => $nextDay
        ];

        $datas = [];
        foreach ($names as $index => $name) {
            $randomNumber = mt_rand(100000000, 999999999) . uniqid();
            $randomNumber = substr($randomNumber, 0, 10);
            $prefix = 'KB'.$randomNumber;
            $data2 = [
                'kode_barang' => $prefix,
                'name' => $name,
                'description' => null,
                'selling_price' => null,
                'purchase_price' => $result[$index],
                'stock' => $quantities[$index],
                'unit' => $units[$index],
                'created_at' => $nextDay,
                'updated_at' => $nextDay
            ];
            $datas[] = $data2;
        }

        if (!$model->insert($data)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'gagal menambahkan hutang'
            ]);
        }

        if (!$modelItem->insertBatch($datas)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'gagal menambahkan hutang'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'berhasil menambahkan hutang'
        ]);
    }

    public function bayar($id)
    {
        helper('number');
        $model = new Hutang();
        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON($model->find($id));
        }

        $cicilAmount = $this->request->getVar('cicil');
        $hutangData = $model->find($id);

        $newCicilAmount = $hutangData['cicil'] + $cicilAmount;
        $status = ($newCicilAmount < $hutangData['hutang']) ? 'cicil' : 'lunas';

        $kembalian = 0;

        if ($cicilAmount > $hutangData['hutang']) {
            $kembalian = $cicilAmount - $hutangData['hutang'];
        }

        $data = [
            'cicil' => $newCicilAmount,
            'status' => $status,
            'updated_at' => date('Y-m-d')
        ];

        if (!$model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal melakukan cicilan hutang.'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Berhasil melakukan cicilan hutang dengan kembalian: '. number_to_currency($kembalian, 'IDR'),
        ]);
    }

    public function details($id)
    {
        $model = new Hutang();
        return $this->response->setJSON([
            'success' => true,
            'data' => $model->find($id),
        ]);   
    }
    
    public function delete($id)
    {
        $model = new Hutang();
        $model->where('id', $id)->delete($id);
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Berhasil hapus data hutang.'
        ]);
    }

    public function exportHutang()
    {
        $model = new Hutang();
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');
        $status = $this->request->getVar('status');

        $data = $model->RangeDate($startDate, $endDate, $status);
        //dd($data);
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->getStyle('D')->getNumberFormat()
                    ->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()->getStyle('A1')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B')->getNumberFormat()
                    ->setFormatCode('0000000000000000');
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Transaksi Hutang')
                    ->setCellValue('A2', 'Supplier')
                    ->setCellValue('B2', 'Hutang')
                    ->setCellValue('C2', 'Total Cicilan')
                    ->setCellValue('D2', 'Status')
                    ->setCellValue('E2', 'Waktu Transaksi');
        $column = 3;
        
        foreach ($data as $data) {        
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data->supplier)
                ->setCellValue('B' . $column, $data->hutang)
                ->setCellValue('C' . $column, $data->cicil)
                ->setCellValue('D' . $column, $data->status)
                ->setCellValue('E' . $column, $data->created_at);
        
            $column++;
        }
        
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Transaksi Hutang '.$startDate.' - '.$endDate;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
