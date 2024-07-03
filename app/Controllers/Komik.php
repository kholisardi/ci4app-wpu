<?php

namespace App\Controllers;

class Komik extends BaseController
{
    protected $komikModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->komikModel = new \App\Models\KomikModel();
    }
    public function index()
    {
        $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar komik',
            'komik' => $komik
        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // jika komik tidak ada di table
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik ' . $slug . ' tidak ditemukan');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {

        $rules = [
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} Komik harus diisi.',
                    'is_unique' => '{field} Komik sudah terdaftar'
                ]
            ],
            'penulis' => 'required',
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar melebihi 1Mb',
                    'is_image' => 'file yang anda pilih bukan gambar',
                    'mime_in' => 'file yang anda pilih bukan gambar'
                ]
            ],
        ];

        $data = $this->request->getPost(array_keys($rules));

        if (!$this->validateData($data, $rules)) {
            return redirect()->back()->withInput();
        }

        // ambil gambar sampul
        $fileSampul = $this->request->getFile('sampul');

        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default-sampul.jpg';
        } else {
            // ambil nama file untuk diinsert ke database
            $namaSampul = $fileSampul->getRandomName();
            // pinfahkan file ke folder Img di publik
            $fileSampul->move('img', $namaSampul);
        }

        $slug = url_title(
            $this->request->getVar('judul'),
            '-',
            true
        );
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);

        session()->setFlashdata('message', 'Data berhasil ditambahkan!');

        return redirect()->to('/komik');
    }

    public function delete($id)
    {

        // hapus gambar dari folder database
        $sampulNama = $this->komikModel->find($id);
        if ($sampulNama['sampul'] != 'default-sampul.jpg') {
            unlink('img/' . $sampulNama['sampul']);
        }

        $this->komikModel->delete($id);
        session()->setFlashdata('message', 'Data berhasil dihapus!');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {

        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));

        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        $rules = [
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} Komik harus diisi.',
                    'is_unique' => '{field} Komik sudah terdaftar'
                ]
            ],
            'penulis' => 'required',
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar melebihi 1Mb',
                    'is_image' => 'file yang anda pilih bukan gambar',
                    'mime_in' => 'file yang anda pilih bukan gambar'
                ]
            ],
        ];
        $data = $this->request->getPost(array_keys($rules));

        if (!$this->validateData($data, $rules)) {
            return redirect()->back()->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar apakah ada perubahan 
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaSampul);

            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title(
            $this->request->getVar('judul'),
            '-',
            true
        );
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);

        session()->setFlashdata('message', 'Data berhasil diubah!');

        return redirect()->to('/komik');
    }
}
