<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use Config\Database;

class AuthController extends BaseController
{

    public function __construct()
    {
        //
    }

    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        $userModel = new User();
        $db = Database::connect();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        $role = $db->table('roles r')
            ->select('name')
            ->join('user_roles ur', 'ur.role_id = r.id')
            ->where('ur.user_id', $user['id'])
            ->get()->getRow();

        session()->set([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role' => $role->name ?? null,
            'logged_in' => true
        ]);

        return redirect()->to('/dashboard');
            
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
