<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('pages.data.customers', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        Customer::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('response', 'Customer berhasil ditambahkan!');
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
        ]);

        $customer = Customer::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil ditambahkan!',
            'data' => $customer
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $customers = Customer::where('nama', 'like', "%{$search}%")
            ->orWhere('telepon', 'like', "%{$search}%")
            ->get();

        return response()->json($customers);
    }
}
