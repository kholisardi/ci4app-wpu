<?php

namespace App\Controllers;


class Pages extends BaseController
{
    public function index()
    {

        // $faker = \Faker\Factory::create();
        // d($faker->address);
        // dd($faker->name);

        $data = [
            'title' => 'Home',
            'test' => ['satu', 'dua', 'tiga'],
        ];

        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'Home',
        ];

        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact us',
            'alamat' => [
                [
                    'tipe' => 'rumah',
                    'alamat' => 'bawuran',
                    'kota' => 'Bantul'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Sentul',
                    'kota' => 'Yogya'
                ],
            ]
        ];

        return view('pages/contact', $data);
    }
}
