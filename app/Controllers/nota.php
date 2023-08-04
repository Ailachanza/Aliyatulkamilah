<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\notaModel;

class nota extends BaseController
{
    protected $bm;
    private $menu;
    private $rules;
    public function __construct()
    {
        $this->bm = new notaModel();
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
                    'aktif'=>'active',
                ],
                'pelanggan'=>[
                    'title'=>'pelanggan',
                    'link'=>base_url().'/pelanggan',
                    'icon'=> 'fa-solid fa-people-group',
                    'aktif'=>'',
                ],
            ];
        $this->rules = [
            'id_nomer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'id_nomer tidak boleh kosong',
                ]
            ],
            'tanggal' =>
            [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal tidak boleh kosong',
                ]
            ],
        ];
    }
    public function index()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">Nota</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item active">Nota</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Data Nota';

        $query = $this->bm->find();
        $data['data_nota'] = $query;
        return view('nota/content', $data);
    }
    public function tambah()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">nota</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="' . base_url() . '/nota">nota</a></li>
                            <li class="breadcrumb-item active">Input Nota</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "Tambah nota";
        $data['action'] = base_url() . '/nota/simpan';
        return view('nota/input', $data);
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
            return redirect()->to('nota')->with('success', 'Data nota Tersimpan');
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
            return redirect()->to('nota')->with('success', 'Data nota dengan kode ' . $id . ' berhasil di hapus');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to('nota')->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">nota</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="' . base_url() . '/nota">nota</a></li>
                            <li class="breadcrumb-item active">Edit nota</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "Edit nota";
        $data['action'] = base_url() . '/nota/update';
        $data['edit_data'] = $this->bm->find($id);
        return view('nota/input', $data);
    }

    public function update()
    {
        $dtEdit = $this->request->getPost();
        $param = $dtEdit['param'];
        unset($dtEdit['param']);
        unset($this->rules['nota']);

        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput();
        }

        if (empty($dtEdit['nota'])) {
            unset($dtEdit['nota']);
        }

        try {
            $this->bm->update($param, $dtEdit);
            return redirect()->to('nota')->with('success', 'Data berhasil diperbarui');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
