<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product listing with search and filters.
     */
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        // Paginate
        $products = $query->paginate(12)->withQueryString();

        // Get categories for filter
        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->orderBy('name')
            ->get();

        // Get selected category name
        $selectedCategory = null;
        if ($request->category) {
            $selectedCategory = Category::where('slug', $request->category)->first();
        }

        return view('frontend.products.index', compact(
            'products',
            'categories',
            'selectedCategory'
        ));
    }

    /**
     * Display single product details.
     */
    public function show($slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Get related products (same category)
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->take(4)
            ->get();

        return view('frontend.products.show', compact(
            'product',
            'relatedProducts'
        ));
    }
}