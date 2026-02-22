<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\AttractionReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttractionController extends Controller
{
    public function index(Request $request)
    {
        $query = Attraction::withCount('reviews')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $attractions = $query->paginate(10)->withQueryString();

        return view('attractions.index', compact('attractions'));
    }

    public function create()
    {
        return view('attractions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'entrance_fee' => 'nullable|numeric|min:0',
            'opening_hours' => 'nullable|array',
            'contact_number' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'category' => 'required|in:temple,beach,mountain,park,museum,island,waterfall,cave',
            'featured_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('attractions', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('attractions/gallery', 'public');
            }
            $validated['gallery'] = $gallery;
        }

        Attraction::create($validated);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction created successfully.');
    }

    public function show(Attraction $attraction)
    {
        $attraction->load(['reviews.customer', 'approvedReviews']);
        return view('attractions.show', compact('attraction'));
    }

    public function edit(Attraction $attraction)
    {
        return view('attractions.edit', compact('attraction'));
    }

    public function update(Request $request, Attraction $attraction)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'entrance_fee' => 'nullable|numeric|min:0',
            'opening_hours' => 'nullable|array',
            'contact_number' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'category' => 'required|in:temple,beach,mountain,park,museum,island,waterfall,cave',
            'featured_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('featured_image')) {
            if ($attraction->featured_image) {
                Storage::disk('public')->delete($attraction->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('attractions', 'public');
        }

        if ($request->hasFile('gallery')) {
            if ($attraction->gallery) {
                foreach ($attraction->gallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('attractions/gallery', 'public');
            }
            $validated['gallery'] = $gallery;
        }

        $attraction->update($validated);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction updated successfully.');
    }

    public function destroy(Attraction $attraction)
    {
        if ($attraction->featured_image) {
            Storage::disk('public')->delete($attraction->featured_image);
        }
        if ($attraction->gallery) {
            foreach ($attraction->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $attraction->delete();

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction deleted successfully.');
    }

    public function toggleFeatured(Attraction $attraction)
    {
        $attraction->update(['is_featured' => !$attraction->is_featured]);
        return back()->with('success', $attraction->is_featured ? 'Attraction marked as featured.' : 'Attraction removed from featured.');
    }

    public function toggleActive(Attraction $attraction)
    {
        $attraction->update(['is_active' => !$attraction->is_active]);
        return back()->with('success', $attraction->is_active ? 'Attraction published.' : 'Attraction unpublished.');
    }

    public function approveReview(AttractionReview $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Review approved.');
    }

    public function rejectReview(AttractionReview $review)
    {
        $review->update(['is_approved' => false]);
        return back()->with('success', 'Review rejected.');
    }

    public function deleteReview(AttractionReview $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
