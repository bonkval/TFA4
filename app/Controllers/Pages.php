<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function home(): string
    {
        return view('pages/home', [
            'title' => 'POS Lab | Home',
            'heading' => 'Point-of-Sale System',
        ]);
    }

    public function about(): string
    {
        return view('pages/about', [
            'title' => 'POS Lab | About',
            'heading' => 'About This Activity',
        ]);
    }
}
