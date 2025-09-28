<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('about');
    }

    public function features()
    {
        return view('features');
    }

    public function contact()
    {
        return view('contact');
    }
    
    public function loginRedirection()
    {
        return view('login-redirection');
    }
}
