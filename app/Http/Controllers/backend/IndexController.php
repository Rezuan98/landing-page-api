<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function adminLogin()
    {
        return view('backend.login');
    }


    public function index()
    {
        return view('backend.index');
    }
}
