<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellController extends Controller
{
    public function index(Request $request)
    {
        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sell page information.'
            ]);
        }
        
        return view('sell.index');
    }
}
