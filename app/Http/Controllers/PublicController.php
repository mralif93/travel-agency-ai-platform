<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PublicController extends Controller
{
    public function transportRates()
    {
        return view('public.transport-rates');
    }

    public function tourPackages()
    {
        return view('public.tour-packages');
    }

    public function attractions()
    {
        return view('public.attractions');
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }
}
