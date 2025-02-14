<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('pages.data.supplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',

        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $suppliers = Supplier::where('nama_vendor', 'like', "%{$search}%")
            ->orWhere('kontak', 'like', "%{$search}%")
            ->get();

        return response()->json($suppliers);
    }
}
