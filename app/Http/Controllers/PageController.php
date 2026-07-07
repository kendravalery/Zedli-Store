<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about.index');
    }
}
/// lanjut lek masalah paymet dan checkout di bagian controllernya
