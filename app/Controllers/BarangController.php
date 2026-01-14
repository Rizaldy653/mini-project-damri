<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Barang;

class BarangController extends BaseController
{
    protected $barang;

    public function __construct()
    {
        $this->barang = new Barang();
    }

    public function index()
    {
        return view('barang/index');
        // $data['barang'] = $this->barang->findAll();
        // return view('barang/index', $data);
    }

    public function getData()
    {
        $data = $this->barang->where('status', '1')->findAll();

        // dd($data);
        log_message('error', json_encode($data));

        // if ($data['status'] == null) {
        //     $data['status'] = '1';
        // }

        return $this->response->setJSON([
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('barang/addItem');
    }


    public function store()
    {
        $rules = [
            'nama_barang' => 'required|min_length[3]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'status'        => 'integer[1,2]'
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $this->barang->insert([
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'status'      => $this->request->getPost('status')
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Barang berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $data = $this->barang->find($id);

        if (! $data) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $this->barang->update($id, [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'stok' => $this->request->getPost('status')
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Barang berhasil diupdate'
        ]);
    }

    public function delete($id)
    {
        $this->barang->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}
