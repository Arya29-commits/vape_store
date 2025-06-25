<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('supplier')->latest()->get();
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('pembelian.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'no_faktur'   => 'required|unique:pembelians',
            'tanggal'     => 'required|date',
            'total'       => 'required|numeric|min:0',
        ]);

        Pembelian::create($request->all());

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil disimpan.');
    }
}
