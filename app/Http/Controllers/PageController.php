<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function appointments()
    {
        return view('pages.appointments');
    }

    public function testimonials()
    {
        return view('pages.testimonials');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}