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
            'comment' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if user already reviewed this product
        if ($product->reviews()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        // Create review (auto-approve for now, or set to false if moderation is needed)
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => true, // Auto-approve
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
