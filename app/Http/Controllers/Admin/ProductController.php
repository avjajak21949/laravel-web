<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toy;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Toy::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ToyName' => 'required|string|max:255',
            'ToyPrice' => 'required|numeric',
            'ToyQuantity' => 'required|integer',
            'CategoryID' => 'required|integer',
        ]);

        Toy::create($validated);
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function edit(Toy $toy)
    {
        return view('admin.products.edit', compact('toy'));
    }

    public function update(Request $request, Toy $toy)
    {
        $validated = $request->validate([
            'ToyName' => 'required|string|max:255',
            'ToyPrice' => 'required|numeric',
            'ToyQuantity' => 'required|integer',
            'CategoryID' => 'required|integer',
        ]);

        $toy->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Toy $toy)
    {
        $toy->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
