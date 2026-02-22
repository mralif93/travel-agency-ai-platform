<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = TourPackage::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $packages = $query->paginate(10)->withQueryString();

        return view('tour-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('tour-packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:100',
            'destination' => 'required|string|max:255',
            'category' => 'required|in:adventure,cultural,nature,beach,city,culinary',
            'featured_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
            'itinerary' => 'nullable|array',
            'max_pax' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,moderate,challenging',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('tour-packages', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('tour-packages/gallery', 'public');
            }
            $validated['gallery'] = $gallery;
        }

        TourPackage::create($validated);

        return redirect()->route('admin.tour-packages.index')->with('success', 'Tour package created successfully.');
    }

    public function show(TourPackage $tourPackage)
    {
        $package = $tourPackage;
        return view('tour-packages.show', compact('package'));
    }

    public function edit(TourPackage $tourPackage)
    {
        $package = $tourPackage;
        return view('tour-packages.edit', compact('package'));
    }

    public function update(Request $request, TourPackage $tourPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:100',
            'destination' => 'required|string|max:255',
            'category' => 'required|in:adventure,cultural,nature,beach,city,culinary',
            'featured_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
            'itinerary' => 'nullable|array',
            'max_pax' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,moderate,challenging',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('featured_image')) {
            if ($tourPackage->featured_image) {
                Storage::disk('public')->delete($tourPackage->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('tour-packages', 'public');
        }

        if ($request->hasFile('gallery')) {
            if ($tourPackage->gallery) {
                foreach ($tourPackage->gallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('tour-packages/gallery', 'public');
            }
            $validated['gallery'] = $gallery;
        }

        $tourPackage->update($validated);

        return redirect()->route('admin.tour-packages.index')->with('success', 'Tour package updated successfully.');
    }

    public function destroy(TourPackage $tourPackage)
    {
        if ($tourPackage->featured_image) {
            Storage::disk('public')->delete($tourPackage->featured_image);
        }
        if ($tourPackage->gallery) {
            foreach ($tourPackage->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $tourPackage->delete();

        return redirect()->route('admin.tour-packages.index')->with('success', 'Tour package deleted successfully.');
    }

    public function toggleFeatured(TourPackage $tourPackage)
    {
        $tourPackage->update(['is_featured' => !$tourPackage->is_featured]);
        return back()->with('success', $tourPackage->is_featured ? 'Package marked as featured.' : 'Package removed from featured.');
    }

    public function toggleActive(TourPackage $tourPackage)
    {
        $tourPackage->update(['is_active' => !$tourPackage->is_active]);
        return back()->with('success', $tourPackage->is_active ? 'Package published.' : 'Package unpublished.');
    }
}
