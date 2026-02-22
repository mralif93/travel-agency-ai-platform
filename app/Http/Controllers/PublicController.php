<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Attraction;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function transportRates()
    {
        $vehicles = \App\Models\Vehicle::where('status', 'active')->get();
        return view('public.transport-rates', compact('vehicles'));
    }

    public function tourPackages(Request $request)
    {
        $query = TourPackage::where('is_active', true)->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $packages = $query->paginate(9)->withQueryString();
        $featuredPackages = TourPackage::where('is_active', true)->where('is_featured', true)->take(3)->get();

        return view('public.tour-packages', compact('packages', 'featuredPackages'));
    }

    public function tourPackageShow(TourPackage $tourPackage)
    {
        if (!$tourPackage->is_active) {
            abort(404);
        }

        $relatedPackages = TourPackage::where('is_active', true)
            ->where('id', '!=', $tourPackage->id)
            ->where('category', $tourPackage->category)
            ->take(3)
            ->get();

        return view('public.tour-package-detail', compact('tourPackage', 'relatedPackages'));
    }

    public function attractions(Request $request)
    {
        $query = Attraction::where('is_active', true)->withCount('reviews')->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $attractions = $query->paginate(12)->withQueryString();
        $featuredAttractions = Attraction::where('is_active', true)->where('is_featured', true)->take(4)->get();

        return view('public.attractions', compact('attractions', 'featuredAttractions'));
    }

    public function attractionShow(Attraction $attraction)
    {
        if (!$attraction->is_active) {
            abort(404);
        }

        $attraction->load(['approvedReviews.customer']);
        $nearbyAttractions = Attraction::where('is_active', true)
            ->where('id', '!=', $attraction->id)
            ->where('location', $attraction->location)
            ->take(4)
            ->get();

        return view('public.attraction-detail', compact('attraction', 'nearbyAttractions'));
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
