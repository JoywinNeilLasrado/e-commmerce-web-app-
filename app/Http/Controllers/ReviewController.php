<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if user already reviewed this product
        if ($product->reviews()->where('user_id', auth()->id())->exists()) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this product.'
                ], 422);
            }
            return back()->with('error', 'You have already reviewed this product.');
        }

        // Create review (auto-approve for now, or set to false if moderation is needed)
        $review = Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => true, // Auto-approve
        ]);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review added successfully',
                'review' => $review
            ]);
        }

        return back()->with('success', 'Thank you for your review!');
    }

    public function update(Request $request, Review $review)
    {
        // Ensure user owns the review
        if ($review->user_id !== auth()->id()) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => true, // Re-approve on edit or set to false to require moderation
        ]);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully.',
                'review' => $review
            ]);
        }

        return back()->with('success', 'Your review has been updated!');
    }
}
