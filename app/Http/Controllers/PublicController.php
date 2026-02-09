<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PublicController extends Controller
{
    public function transportRates()
    {
        $vehicles = \App\Models\Vehicle::where('status', 'active')->get();
        return view('public.transport-rates', compact('vehicles'));
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
