<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TawarController extends Controller
{
    public function index()
    {
        return view('petani.tawar');
    }
}
