<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['phoneModel.brand', 'variants'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(8)
            ->get();

        $brands = Brand::where('is_active', true)
            ->where('is_featured', true)
            ->get();

        return view('home', compact('featuredProducts', 'brands'));
    }
}
