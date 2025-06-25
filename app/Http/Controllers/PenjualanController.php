<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
{
    $penjualans = \App\Models\Penjualan::with('barang')->latest()->get();
    return view('penjualan.index', compact('penjualans'));
}

 public function create()
{
    $barangs = Barang::all();
    return view('penjualan.create', compact('barangs'));
}

public function tambahKeranjang(Request $request)
{
    $item = [
        'id' => $request->id,
        'nama' => $request->nama,
        'harga' => $request->harga,
        'jumlah' => $request->jumlah,
        'subtotal' => $request->harga * $request->jumlah
    ];

    $keranjang = session()->get('keranjang', []);
    $keranjang[] = $item;
    session()->put('keranjang', $keranjang);

    return redirect('/keranjang')->with('success', 'Barang ditambahkan ke keranjang.');
}

public function lihatKeranjang()
{
    $keranjang = session()->get('keranjang', []);
    return view('penjualan.keranjang', compact('keranjang'));
}

public function simpanPenjualan(Request $request)
{
     $keranjang = session()->get('keranjang', []);

    foreach ($keranjang as $item) {
        Penjualan::create([
            'barang_id' => $item['id'],
            'jumlah' => $item['jumlah'],
            'total_harga' => $item['subtotal'],
            'pelanggan' => $request->pelanggan ?? 'Umum', // ← ubah ke 'pelanggan'
            'tanggal' => Carbon::today()
        ]);
    }

    session()->forget('keranjang');
    return redirect('/penjualan/create')->with('success', 'Penjualan berhasil disimpan.');
}
}