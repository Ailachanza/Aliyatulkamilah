<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\barangModel;

class barang extends BaseController
{
    protected $bm;
    private $menu;
    private $rules;
    public function __construct()
    {
        $this->bm = new barangModel();
        $this->menu
            = [
                'beranda'=>[
                    'title'=>'Beranda',
                    'link'=>base_url(),
                    'icon'=> 'fa-solid fa-house-chimney-window',
                    'aktif'=>'',
                ],
                'barang'=>[
                    'title' =>'barang',
                    'link' =>base_url() . '/barang',
                    'icon' => 'fa-solid fa-box-open',
                    'aktif' =>'active',
                ],
                'nota'=>[
                    'title'=>'nota',
                    'link'=>base_url().'/nota',
                    'icon'=> 'fa-solid fa-clipboard',
                    'aktif'=>'',
                ],
                'pelanggan'=>[
                    'title'=>'pelanggan',
                    'link'=>base_url().'/pelanggan',
                    'icon'=> 'fa-solid fa-people-group',
                    'aktif'=>'',
                ],
            ];
        $this->rules = [
            'no_barang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'no_barang tidak boleh kosong',
                ]
            ],
            'nama_barang' =>
            [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama_barang tidak boleh kosong',
                ]
            ],
            'satuan' =>
            [
                'rules' => 'required',
                'errors' => [
                    'required' => 'satuan tidak boleh kosong',
                ]
            ],
            'harga' =>
            [
                'rules' => 'required',
                'errors' => [
                    'required' => 'harga tidak boleh kosong',
                ]
            ],
        ];
    }
    public function index()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">Barang</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item active">Barang</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Data Barang';

        $query = $this->bm->find();
        $data['data_barang'] = $query;
        return view('barang/content', $data);
    }
    public function tambah()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">barang</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="' . base_url() . '/barang">barang</a></li>
                            <li class="breadcrumb-item active">Input Barang</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "Tambah barang";
        $data['action'] = base_url() . '/barang/simpan';
        return view('barang/input', $data);
    }

    public function simpan()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {

            return redirect()->back()->withInput();
        }
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput();
        }
        $dt = $this->request->getPost();

        try {
            $simpan = $this->bm->insert($dt);
            return redirect()->to('barang')->with('success', 'Data barang Tersimpan');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {

            session()->setFlashdata('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function hapus($id)
    {
        if (empty($id)) {
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
        try {
            $this->bm->delete($id);
            return redirect()->to('barang')->with('success', 'Data barang dengan kode ' . $id . ' berhasil di hapus');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to('barang')->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">barang</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="' . base_url() . '/barang">barang</a></li>
                            <li class="breadcrumb-item active">Edit barang</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "Edit barang";
        $data['action'] = base_url() . '/barang/update';
        $data['edit_data'] = $this->bm->find($id);
        return view('barang/input', $data);
    }

    public function update()
    {
        $dtEdit = $this->request->getPost();
        $param = $dtEdit['param'];
        unset($dtEdit['param']);
        unset($this->rules['barang']);

        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput();
        }

        if (empty($dtEdit['barang'])) {
            unset($dtEdit['barang']);
        }

        try {
            $this->bm->update($param, $dtEdit);
            return redirect()->to('barang')->with('success', 'Data berhasil diperbarui');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
