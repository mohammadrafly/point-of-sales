<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;

class UserController extends BaseController
{
    public function index()
    {
        $model = new Users();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->findAll(),
            ];
            return view('pages/dashboard/user', $data);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
            'phone_number' => $this->request->getPost('phone_number'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
        ];

        if ($model->like('username', $data['username'])->get()->getResultArray()) {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data pengguna, username telah digunakan.'
            ]);
        }

        if ($model->like('email', $data['email'])->get()->getResultArray()) {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data pengguna, email telah digunakan.'
            ]);
        }

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data pengguna'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data pengguna'
            ]);
        }
    }

    public function update($id = null)
    {
        $model = new Users();

        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON([
                'success' => TRUE,
                'data' => $model->where('id', $id)->first()
            ]);
        }

        $data = [
            'address' => $this->request->getPost('address'),
            'phone_number' => $this->request->getPost('phone_number'),
            //'username' => $this->request->getPost('username'),
            //'email' => $this->request->getPost('email'),
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        //if ($model->like('username', $data['username'])->get()->getResultArray()) {
        //    return $this->response->setJSON([
        //        'success' => FALSE,
        //        'message' => 'Gagal simpan data pengguna, username telah digunakan.'
        //    ]);
        //}

        //if ($model->like('email', $data['email'])->get()->getResultArray()) {
        //    return $this->response->setJSON([
        //        'success' => FALSE,
        //        'message' => 'Gagal simpan data pengguna, email telah digunakan.'
        //    ]);
        //}

        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data pengguna'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data pengguna'
            ]);
        }
    }

    public function delete($id = null) 
    {
        $model = new Users();
        if ($model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil hapus data pengguna'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal hapus data pengguna'
            ]);
        }
    }
}
