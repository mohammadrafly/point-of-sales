<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;

class UserController extends BaseController
{
    //Customer
    public function index()
    {
        $model = new Users();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->where('role', 'customer')->findAll(),
            ];
            return view('pages/dashboard/customer', $data);
        }

        $data = [
            'username' => NULL,
            'email' => $this->request->getVar('email'),
            'address' => $this->request->getVar('address'),
            'phone_number' => $this->request->getVar('phone_number'),
            'password' => NULL,
            'name' => $this->request->getVar('name'),
            'role' => 'customer',
        ];

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data customer'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data customer'
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
            'address' => $this->request->getVar('address'),
            'phone_number' => $this->request->getVar('phone_number'),
            'name' => $this->request->getVar('name'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data customer'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data customer'
            ]);
        }
    }

    public function delete($id = null) 
    {
        $model = new Users();
        if ($model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil hapus data customer'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal hapus data customer'
            ]);
        }
    }

    //Kasir
    public function indexKasir()
    {
        $model = new Users();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->where('role', 'kasir')->findAll(),
            ];
            return view('pages/dashboard/kasir', $data);
        }

        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'address' => $this->request->getVar('address'),
            'phone_number' => $this->request->getVar('phone_number'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'name' => $this->request->getVar('name'),
            'role' => 'kasir',
        ];

        if ($model->like('username', $data['username'])->get()->getResultArray()) {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data kasir, username telah digunakan.'
            ]);
        }

        if ($model->like('email', $data['email'])->get()->getResultArray()) {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data kasir, email telah digunakan.'
            ]);
        }

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data kasir'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data kasir'
            ]);
        }
    }

    public function updateKasir($id = null)
    {
        $model = new Users();

        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON([
                'success' => TRUE,
                'data' => $model->where('id', $id)->first()
            ]);
        }

        $data = [
            'address' => $this->request->getVar('address'),
            'phone_number' => $this->request->getVar('phone_number'),
            'name' => $this->request->getVar('name'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data kasir'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data kasir'
            ]);
        }
    }

    public function deleteKasir($id = null) 
    {
        $model = new Users();
        if ($model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil hapus data kasir'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal hapus data kasir'
            ]);
        }
    }

    //Admin
    public function indexAdmin()
    {
        $model = new Users();

        if ($this->request->getMethod(true) !== 'POST') {
            $data = [
                'content' => $model->where('role', 'admin')->findAll(),
            ];
            return view('pages/dashboard/admin', $data);
        }

        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'address' => $this->request->getVar('address'),
            'phone_number' => $this->request->getVar('phone_number'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'name' => $this->request->getVar('name'),
            'role' => 'admin',
        ];

        if ($model->like('username', $data['username'])->get()->getResultArray()) {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data admin, username telah digunakan.'
            ]);
        }

        if ($model->like('email', $data['email'])->get()->getResultArray()) {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data admin, email telah digunakan.'
            ]);
        }

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data admin'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data admin'
            ]);
        }
    }

    public function updateAdmin($id = null)
    {
        $model = new Users();

        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON([
                'success' => TRUE,
                'data' => $model->where('id', $id)->first()
            ]);
        }

        $data = [
            'address' => $this->request->getVar('address'),
            'phone_number' => $this->request->getVar('phone_number'),
            'name' => $this->request->getVar('name'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil simpan data admin'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal simpan data admin'
            ]);
        }
    }

    public function deleteAdmin($id = null) 
    {
        $model = new Users();
        if ($model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Berhasil hapus data admin'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Gagal hapus data admin'
            ]);
        }
    }
}
