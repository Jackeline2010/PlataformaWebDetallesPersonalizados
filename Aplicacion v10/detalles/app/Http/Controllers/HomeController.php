<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Show the home page with products and categories.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            // Load active categories ordered by 'orden' field
            $categories = Category::where('activo', true)
                                ->orderBy('orden')
                                ->get();
            
            // Load active products with their categories, ordered by 'orden' and creation date
            $products = Product::with('categories')
                              ->where('activo', true)
                              ->orderBy('orden')
                              ->orderBy('created_at', 'desc')
                              ->get();
            
            return view('shop.home', compact('categories', 'products'));
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error loading home page data: ' . $e->getMessage());
            
            // Return view with empty collections to prevent errors
            $categories = collect();
            $products = collect();
            
            return view('shop.home', compact('categories', 'products'))
                   ->with('error', 'Hubo un problema al cargar los productos. Por favor, intenta más tarde.');
        }
    }
}
