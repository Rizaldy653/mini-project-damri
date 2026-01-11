<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('test');
    }

    public function table()
    {
        return view('table');
    }
}
