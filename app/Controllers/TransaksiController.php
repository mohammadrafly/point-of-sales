<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transactions;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransaksiController extends BaseController
{
    public function index()
    {
        helper('number');
        $model = new Transactions();
        $data = [
            'tunai' => true,
            'content' => $model->joinTransactionsWithUsersByPaymentType('tunai'),
        ];

        return view('pages/dashboard/list_transaction', $data);
    }

    public function indexHutang()
    {
        helper('number');
        $model = new Transactions();
        $data = [
            'tunai' => false,
            'content' => $model->joinTransactionsWithUsersByPaymentType('hutang'),
        ];

        return view('pages/dashboard/list_transaction', $data);
    }

    public function bayarHutang($transactionCode)
    {
        $model = new Transactions();
    
        // Get the total by transaction code
        $total = $model->getTotalByTransactionCode($transactionCode);
    
        if ($total === null) {
            // Transaction code not found
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction code not found',
            ]);
        }
    
        $cicilAmount = $this->request->getVar('cicil');
    
        if ($cicilAmount > $total) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'The cicil amount cannot be greater than the total price',
            ]);
        }
    
        // Retrieve the existing value of 'cicil' from the database
        $existingCicil = $model->select('cicil')->where('transaction_code', $transactionCode)->first();
        $existingCicilAmount = $existingCicil['cicil'] ?? 0;
    
        // Calculate the new value of 'cicil' by adding the new amount to the existing amount
        $newCicilAmount = $existingCicilAmount + $cicilAmount;
    
        $remainingBalance = $total - $newCicilAmount;
    
        if ($remainingBalance <= 0) {
            // The remaining balance is met, mark the status as 'done'
            $status = 'done';
        } else {
            $status = 'cicil';
        }
        $currentDate = date('Y-m-d');
        $nextDay = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        $data = [
            'status' => $status,
            'cicil' => $newCicilAmount,
            'updated_at' => $nextDay,
        ];
        $model->where('transaction_code', $transactionCode)->set($data)->update();
    
        $updatedCount = $model->affectedRows();
    
        if ($updatedCount === 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update the data',
            ]);
        }
    
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

    public function exportTunai()
    {
        $model = new Transactions();
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');

        $data = $model->RangeDate($startDate, $endDate, 'tunai', 'done');
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
                    ->setCellValue('A1', 'Transaksi Tunai')
                    ->setCellValue('A2', 'Kode Transaksi')
                    ->setCellValue('B2', 'Customer')
                    ->setCellValue('C2', 'Total')
                    ->setCellValue('D2', 'Status')
                    ->setCellValue('E2', 'Waktu Transaksi');
        $column = 3;
        $transactionCodes = array_column($data, 'transaction_code');
        $uniqueTransactionCodes = array_unique($transactionCodes);
        
        foreach ($uniqueTransactionCodes as $transactionCode) {
            $totalPrice = 0;
            foreach ($data as $row) {
                if ($row->transaction_code == $transactionCode) {
                    $totalPrice += $row->total_price;
                }
            }
        
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $transactionCode)
                ->setCellValue('B' . $column, $data[0]->nama_user)
                ->setCellValue('C' . $column, $totalPrice)
                ->setCellValue('D' . $column, $data[0]->status)
                ->setCellValue('E' . $column, $data[0]->created_at);
        
            $column++;
        }
        
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Transaksi Tunai '.$startDate.' - '.$endDate;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function exportHutang()
    {
        $model = new Transactions();
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');
        $status = $this->request->getVar('status');

        $data = $model->RangeDate($startDate, $endDate, 'hutang', $status);
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
                    ->setCellValue('A1', 'Transaksi Piutang')
                    ->setCellValue('A2', 'Kode Transaksi')
                    ->setCellValue('B2', 'Customer')
                    ->setCellValue('C2', 'Total')
                    ->setCellValue('D2', 'Status')
                    ->setCellValue('E2', 'Waktu Transaksi');
        $column = 3;
        $transactionCodes = array_column($data, 'transaction_code');
        $uniqueTransactionCodes = array_unique($transactionCodes);
        
        foreach ($uniqueTransactionCodes as $transactionCode) {
            $totalPrice = 0;
            foreach ($data as $row) {
                if ($row->transaction_code == $transactionCode) {
                    $totalPrice += $row->total_price;
                }
            }
        
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $transactionCode)
                ->setCellValue('B' . $column, $data[0]->nama_user)
                ->setCellValue('C' . $column, $totalPrice)
                ->setCellValue('D' . $column, $data[0]->status)
                ->setCellValue('E' . $column, $data[0]->created_at);
        
            $column++;
        }
        
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Transaksi Piutang '.$startDate.' - '.$endDate;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
