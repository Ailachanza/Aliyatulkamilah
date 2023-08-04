<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\pelangganModel;

class pelanggan extends BaseController
{
    protected $bm;
    private $menu;
    private $rules;
    public function __construct()
    {
        $this->bm = new pelangganModel();
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
                    'aktif' =>'',
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
                    'aktif'=>'active',
                ],
            ];
        $this->rules = [
            'nama_pelanggan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama_pelanggan tidak boleh kosong',
                ]
            ],
            'alamat' =>
            [
                'rules' => 'required',
                'errors' => [
                    'required' => 'alamat tidak boleh kosong',
                ]
            ],
            'no_hp' =>
            [
                'rules' => 'required',
                'errors' => [
                    'required' => 'no_hp tidak boleh kosong',
                ]
            ],
            'kode_pos' =>
            [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kode_pos tidak boleh kosong',
                ]
            ],
        ];
    }
    public function index()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">Pelanggan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item active">Pelanggan</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Data Pelanggan';

        $query = $this->bm->find();
        $data['data_pelanggan'] = $query;
        return view('pelanggan/content', $data);
    }
    public function tambah()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">pelanggan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="' . base_url() . '/pelanggan">pelanggan</a></li>
                            <li class="breadcrumb-item active">Input Pelanggan</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "Tambah pelanggan";
        $data['action'] = base_url() . '/pelanggan/simpan';
        return view('pelanggan/input', $data);
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
            return redirect()->to('pelanggan')->with('success', 'Data pelanggan Tersimpan');
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
            return redirect()->to('pelanggan')->with('success', 'Data pelanggan dengan kode ' . $id . ' berhasil di hapus');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to('pelanggan')->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">pelanggan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="' . base_url() . '/pelanggan">pelanggan</a></li>
                            <li class="breadcrumb-item active">Edit pelanggan</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "Edit pelanggan";
        $data['action'] = base_url() . '/pelanggan/update';
        $data['edit_data'] = $this->bm->find($id);
        return view('pelanggan/input', $data);
    }

    public function update()
    {
        $dtEdit = $this->request->getPost();
        $param = $dtEdit['param'];
        unset($dtEdit['param']);
        unset($this->rules['pelanggan']);

        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput();
        }

        if (empty($dtEdit['pelanggan'])) {
            unset($dtEdit['pelanggan']);
        }

        try {
            $this->bm->update($param, $dtEdit);
            return redirect()->to('pelanggan')->with('success', 'Data berhasil diperbarui');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
