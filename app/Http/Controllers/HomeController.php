<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function index()
    {
        if (Auth::check())
            return redirect()->route('dashboard');
        return view('home');
    }
} 
