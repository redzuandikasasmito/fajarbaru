<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::latest()->paginate(10);
        return view('pages.data.sales', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        Sales::create($request->all());

        return redirect()->route('sales.index')
            ->with('success', 'Sales berhasil ditambahkan');
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'status' => 'required'
        ]);

        $sales = Sales::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Sales Berhasil Ditambahkan',
            'data' => $sales
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $sales = Sales::where('nama', 'like', "%{$search}%")
            ->orWhere('telepon', 'like', "%{$search}%")
            ->get();

        return response()->json($sales);
    }
}
