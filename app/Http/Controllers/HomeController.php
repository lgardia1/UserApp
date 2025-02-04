<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function home()
    {
        return view('home');
    }

    public function index() {
        return view('index');
    }

    public function settings() {
        return view('settings');
    }
    
    public function verification() {
        return view('auth.verify');
    }
    
}
