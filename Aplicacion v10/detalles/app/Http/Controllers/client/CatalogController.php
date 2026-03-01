<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $products = Product::query()
            ->when($q, fn($query) => $query->where('nombre', 'like', "%{$q}%"))
            ->latest()
            ->paginate(12);

        return view('client.catalog', compact('products', 'q'));
    }
}
