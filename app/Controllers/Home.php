<?php

namespace App\Controllers;

use App\Models\Tabeldatalokasiobjek;
use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $tabeldatalokasiobjek;

    public function __construct()
    {
        $this->tabeldatalokasiobjek = new Tabeldatalokasiobjek();
    }
    public function index()
    {
        return view('v_peta');
    }

    public function input()
    {
        return view('v_input');
    }

    public function simpan_tambah_data()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Latitude harus diisi'
                ]
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Longitude harus diisi'
                ]
            ],
        ])) {
            return redirect()->to(base_url('home/input'))
                ->with(
                    'message',
                    array(
                        'type' => 'danger',
                        'content' => $this->validator->listErrors()
                    )
                );
        }

        // menangkap file upload 
        $foto = $this->request->getFile('foto');

        if ($foto->getError() == 4) {
            $nama_foto = NULL;
        } else {
            // membuat folder upload foto 
            $foto_dir = 'upload/foto/';
            if (!is_dir($foto_dir)) {
                mkdir($foto_dir, 0777, TRUE);
            }

            // get foto name 
            $nama_foto = preg_replace('/\s+/', '_', $foto->getName());

            // memindahkan file 
            $foto->move($foto_dir, $nama_foto);
        }

        $data = [
            'nama' => $_POST['nama'],
            'deskripsi' => $_POST['deskripsi'],
            'latitude' => $_POST['latitude'],
            'longitude' => $_POST['longitude'],
            'foto' => $nama_foto,
        ];

        if (!$this->tabeldatalokasiobjek->save($data)) {
            return redirect()->to(base_url('home/input'))
                ->with(
                    'message',
                    array(
                        'type' => 'danger',
                        'content' => 'Data gagal disimpan'
                    )
                );
        }

        return redirect()->to(base_url('home/input'))
            ->with(
                'message',
                array(
                    'type' => 'success',
                    'content' => 'Data berhasil disimpan'
                )
            );
    }

    public function tabel()
    {
        $data['dataobjek'] = $this->tabeldatalokasiobjek->findAll();

        return view('v_tabel', $data);
    }

    public function hapus_data($id)
    {
        $this->tabeldatalokasiobjek->delete($id);
        return redirect()->to(base_url('home/tabel'))
            ->with(
                'message',
                array(
                    'type' => 'success',
                    'content' => 'Data berhasil dihapus'
                )
            );
    }

    public function edit_data($id)
    {
        $data['dataobjek'] = $this->tabeldatalokasiobjek->find($id);

        return view('v_edit', $data);
    }

    public function simpan_edit_data($id)
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Latitude harus diisi'
                ]
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Longitude harus diisi'
                ]
            ],
        ])) {
            return redirect()->to(base_url('home/input'))
                ->with(
                    'message',
                    array(
                        'type' => 'danger',
                        'content' => $this->validator->listErrors()
                    )
                );
        }

        // menangkap file upload 
        $foto = $this->request->getFile('foto');
        $fotolama = $_POST['fotolama'];


        if ($foto->getError() == 4) {
            $nama_foto = $fotolama;
        } else {
            // membuat folder upload foto 
            $foto_dir = 'upload/foto/';
            if (!is_dir($foto_dir)) {
                mkdir($foto_dir, 0777, TRUE);
            }

            // hapus foto lama
            if ($fotolama != "") {
                unlink($foto_dir . $fotolama);
            }


            // get foto name 
            $nama_foto = preg_replace('/\s+/', '_', $foto->getName());

            // memindahkan file 
            $foto->move($foto_dir, $nama_foto);
        }

        $data = [
            'id' => $id,
            'nama' => $_POST['nama'],
            'deskripsi' => $_POST['deskripsi'],
            'latitude' => $_POST['latitude'],
            'longitude' => $_POST['longitude'],
            'foto' => $nama_foto,
        ];

        if (!$this->tabeldatalokasiobjek->save($data)) {
            return redirect()->to(base_url('home/tabel'))
                ->with(
                    'message',
                    array(
                        'type' => 'danger',
                        'content' => 'Data gagal diedit'
                    )
                );
        }

        return redirect()->to(base_url('home/tabel'))
            ->with(
                'message',
                array(
                    'type' => 'success',
                    'content' => 'Data berhasil diedit'
                )
            );
    }

    public function peta()
    {
        return view('v_peta');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function test()
    {
        if (auth()->loggedIn()) {
            echo "user sudah login";
        } else {
            echo "user belum login";
        }
    }
}
