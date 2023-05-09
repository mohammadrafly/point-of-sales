<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;


class DashboardController extends BaseController
{
    public function index()
    {
        return view('pages/dashboard/index');
    }

    private function read_file($file_path) {
        $file_contents = file_get_contents($file_path);
        return $file_contents;
    }

    public function profileToko()
    {
        $json_file_path = WRITEPATH . 'data-toko.json';
    
        if ($this->request->getMethod(true) === 'POST') {
            $data = [
                'nama_toko' => $this->request->getVar('nama_toko'),
                'nama_pemilik' => $this->request->getVar('nama_pemilik'),
                'nomor_telepon' => $this->request->getVar('nomor_telepon'),
                'alamat' => $this->request->getVar('alamat'),
            ];
    
            $json_data = json_encode($data);
    
            if (!file_put_contents($json_file_path,$json_data)) {
                return redirect()->to('dashboard/profile-toko')->with('error', 'Gagal menyimpan data toko');
            }
    
            return redirect()->to('dashboard/profile-toko')->with('success', 'Profile toko berhasil diperbarui');
        }
    
        if (!is_file($json_file_path)) {
            return view('pages/dashboard/profile');
        }
    
        $json_data = $this->read_file($json_file_path);
    
        $data = json_decode($json_data, true);
    
        if (!$data) {
            return view('pages/dashboard/profile');
        }
        return view('pages/dashboard/profile', $data);
    }
    

    public function Logout()
    {
        session()->destroy();
        return $this->response->setJSON([
            'success' => TRUE,
            'message' => 'Logout Berhasil',
        ]);
    }
}
