<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured products and categories.
     */
    public function index()
    {
        $featuredProducts = Product::active()
            ->featured()
            ->inStock()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->orderBy('active_products_count', 'desc')
            ->take(6)
            ->get();

        $latestProducts = Product::active()
            ->inStock()
            ->with('category')
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.home.index', compact(
            'featuredProducts',
            'categories',
            'latestProducts'
        ));
    }
}