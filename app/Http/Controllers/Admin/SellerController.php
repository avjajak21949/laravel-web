<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::all();
        return view('admin.sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('admin.sellers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'SellerName' => 'required|string|max:255',
            'SellerEmail' => 'required|email|unique:sellers,SellerEmail',
            'SellerPhoneNum' => 'required|string|max:15',
            'SellerPassword' => 'required|string|min:6',
            'AdminID' => 'nullable|integer',
        ]);

        Seller::create([
            'SellerName' => $validated['SellerName'],
            'SellerEmail' => $validated['SellerEmail'],
            'SellerPhoneNum' => $validated['SellerPhoneNum'],
            'SellerPassword' => bcrypt($validated['SellerPassword']),
            'AdminID' => $validated['AdminID'],
        ]);

        return redirect()->route('sellers.index')->with('success', 'Seller account created successfully.');
    }

    public function edit(Seller $seller)
    {
        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, Seller $seller)
    {
        $validated = $request->validate([
            'SellerName' => 'required|string|max:255',
            'SellerEmail' => 'required|email|unique:sellers,SellerEmail,' . $seller->SellerID . ',SellerID',
            'SellerPhoneNum' => 'required|string|max:15',
        ]);

        $seller->update($validated);

        return redirect()->route('sellers.index')->with('success', 'Seller account updated successfully.');
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('sellers.index')->with('success', 'Seller account deleted successfully.');
    }
}
