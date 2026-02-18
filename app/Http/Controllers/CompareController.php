<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        // Get up to 3 product IDs from query string: ?ids[]=1&ids[]=2&ids[]=3
        $ids = array_slice((array) $request->input('ids', []), 0, 3);

        $compareProducts = collect();
        if (!empty($ids)) {
            $compareProducts = Product::with([
                'phoneModel.brand',
                'phoneModel',
                'variants.condition',
                'images',
            ])
            ->whereIn('id', $ids)
            ->where('is_active', true)
            ->get()
            ->sortBy(fn($p) => array_search($p->id, $ids))
            ->values();
        }

        // All active products for the selector dropdowns
        $allProducts = Product::with('phoneModel.brand')
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('compare.index', compact('compareProducts', 'allProducts', 'ids'));
    }
}
