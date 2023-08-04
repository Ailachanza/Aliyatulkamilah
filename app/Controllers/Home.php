<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $menu = [
            'beranda'=>[
                'title'=>'Beranda',
                'link'=>base_url(),
                'icon'=> 'fa-solid fa-house-chimney-window',
                'aktif'=>'active',
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
                'aktif'=>'',
            ],
        ];
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">Beranda</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Beranda</li>
                            </ol>
                        </div>';
        $data['menu'] = $menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "Selamat Datang di My Website";
        $data['selamat_datang'] = "Aplikasikan fitur dengan baik";
        return view('template/content', $data);
    }
}
