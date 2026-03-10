<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('category')->latest()->get();
        return view('pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $categories = Category::all();
    return view('pages.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Products::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()
            ->route('products')
            ->with('success','Product created successfully');
    }



    // public function show(string $id)
    // {
    //     $product = Products::with('category')->findOrFail($id);

    //     return view('pages.product.show', compact('product'));
    // }



    public function edit(string $id)
    {
        $product = Products::findOrFail($id);
        $categories = Category::all();

        return view('pages.product.edit', compact('product','categories'));
    }



    public function update(Request $request, string $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()
            ->route('products')
            ->with('success','Product updated successfully');
    }



    public function destroy(string $id)
    {
        $product = Products::findOrFail($id);

        $product->delete();

        return redirect()
            ->route('products')
            ->with('success','Product deleted successfully');
    }

}
