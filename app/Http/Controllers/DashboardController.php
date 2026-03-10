<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

public function index()
{
    $totalCategories = Category::count();
    $totalProducts = Products::count();
   $activeProducts = Products::where('is_active',1)->count();
   $activeCategories = Category::where('is_active',1)->count();
    $topCategories = Category::select(
            'categories.id',
            'categories.name',
            DB::raw('COUNT(products.id) as total_products')
        )
        ->leftJoin('products', 'products.category_id', '=', 'categories.id')
        ->groupBy('categories.id', 'categories.name')
        ->orderByDesc('total_products')
        ->take(5)
        ->get()
        ->map(function ($category) use ($totalProducts) {

            $category->percent = $totalProducts > 0
                ? round(($category->total_products / $totalProducts) * 100)
                : 0;

            return $category;
        });

    return view('pages.index', compact(
        'totalCategories',
        'totalProducts',
        'activeProducts',
        'activeCategories',
        'topCategories'
    ));
}


}
