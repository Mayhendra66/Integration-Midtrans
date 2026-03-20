<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use App\Models\Transactions; // ← add this import at the top
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

public function index()
{   
    $totalRevenue       = Transactions::where('status', 'success')->sum('total_price');
    $totalTransactions  = Transactions::count();
    $successTransactions = Transactions::where('status', 'success')->count();
    
    // ← payment success rate percentage
    $paymentRate = $totalTransactions > 0
        ? round(($successTransactions / $totalTransactions) * 100)
        : 0;

    $totalCategories  = Category::count();
    $totalProducts    = Products::count();
    $activeProducts   = Products::where('is_active', 1)->count();
    $activeCategories = Category::where('is_active', 1)->count();
    $recentTransactions = Transactions::with('product')
    ->latest()
    ->take(5)
    ->get();

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
        'topCategories',
        'totalRevenue',
        'totalTransactions',
        'successTransactions',
        'paymentRate',
        'recentTransactions'
    ));
}


}
