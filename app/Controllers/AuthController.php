<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use CodeIgniter\Log\Logger;

class AuthController extends BaseController
{
    private function setSession($data)
    {
        return session()->set([
            'isLoggedIn' => TRUE,
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'role' => $data['role'],
            'login_time' => date('Y-m-d H:i:s')
        ]);
    }

    public function index()
    {   
        return view('pages/auth/login', ['title' => 'Login']);
        
    }

    public function Login()
    {
        $usernameOrEmail = $this->getUserByUsernameOrEmail($this->request->getPost('username'));
        if (!$usernameOrEmail) {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Username/Email invlid',
            ]);
        }

        $password = $this->request->getPost('password');
        if ($this->isPasswordValid($password, $usernameOrEmail['password'])) {
            $this->setSession($usernameOrEmail);
            return $this->response->setJSON([
                'success' => TRUE,
                'message' => 'Login berhasil!',
                'role' => $usernameOrEmail['role']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => FALSE,
                'message' => 'Password invalid',
            ]);
        }    
    }

    private function getUserByUsernameOrEmail($usernameOrEmail)
    {
        $model = new Users();
        return $model->like('username', $usernameOrEmail)->orLike('email', $usernameOrEmail)->get()->getRowArray();
    }

    private function isPasswordValid($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}
