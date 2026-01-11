<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database;

class UserController extends BaseController
{
    protected $user;
    protected $db;

    public function __construct()
    {
        $this->user = new User();
        $this->db = Database::connect();
    }

    public function index()
    {
        $data['users'] = $this->user->select('users.*, roles.name as role_name')
            ->join('user_roles', 'user_roles.user_id = users.id')
            ->join('roles', 'roles.id = user_roles.role_id')
            ->findAll();

        $data['roles'] = $this->db->table('roles')->get()->getResult();
        $data['title'] = "Manajemen User";

        return view('user/index', $data);
    }

    public function data()
    {
        $users = $this->user->select('users.id, users.name, users.email, roles.name as role_name')
            ->join('user_roles', 'user_roles.user_id = users.id')
            ->join('roles', 'roles.id = user_roles.role_id')
            ->findAll();

        return $this->response->setJSON(['data' => $users]);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah User',
            'roles' => $this->db->table('roles')->get()->getResult()
        ];

        return view('user/addUser', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role_id'  => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transStart();

        try {
            $this->user->insert([
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ]);

            $userId = $this->user->getInsertID();
            $roleId = $this->request->getPost('role_id');

            $this->db->table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $roleId
            ]);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return redirect()->back()->with('error', 'Gagal menyimpan data ke database.');
            }

            return redirect()->back()->with('success', 'User berhasil ditambahkan');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id = null)
    {
        $db = \Config\Database::connect();

        $user = $this->user->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'User tidak ditemukan']);
        }

        $userRole = $db->table('user_roles')
                    ->where('user_id', $id)
                    ->get()
                    ->getRow();

        return $this->response->setJSON([
            'user'    => $user,
            'role_id' => $userRole ? $userRole->role_id : ''
        ]);
    }

    public function update($id = null)
    {
        $this->db->transStart();

        $userData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->user->update($id, $userData);

        $this->db->table('user_roles')->where('user_id', $id)->delete();
        $this->db->table('user_roles')->insert([
            'user_id' => $id,
            'role_id' => $this->request->getPost('role_id')
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON([
                'status'  => false, 
                'message' => 'Gagal memperbarui data user.'
            ]);
        }

        return $this->response->setJSON([
            'status'  => true, 
            'message' => 'User berhasil diperbarui.'
        ]);
    }

    public function delete($id)
    {
        $this->db->transStart();

        $this->db->table('user_roles')->where('user_id', $id)->delete();
        $this->db->table('user_permissions')->where('user_id', $id)->delete();
        
        $this->user->delete($id);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON(['status' => false, 'message' => 'Gagal menghapus user']);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'User berhasil dihapus']);
    }
}
