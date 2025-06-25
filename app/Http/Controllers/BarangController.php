<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori; // Tetap impor Kategori karena kita akan mencarinya

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang dengan fitur pencarian dan filter kategori.
     * (Tidak ada perubahan signifikan di sini, karena ini untuk halaman index)
     */
    public function index(Request $request)
    {
        $kategoris = Kategori::all(); // Untuk dropdown filter
    $query = Barang::with('kategori');

    // Filter berdasarkan nama
    if ($request->filled('search')) {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan kategori
    if ($request->filled('kategori_id')) {
        $query->where('id_kategori', $request->kategori_id);
    }

    $barangs = $query->latest()->get();

    return view('barang.index', [
        'barangs' => $barangs,
        'kategoris' => $kategoris,
        'search' => $request->search,
        'selectedKategori' => $request->kategori_id
    ]);
    }

    /**
     * Menampilkan form untuk membuat barang baru.
     * HAPUS PENGAMBILAN KATEGORI KARENA SEKARANG STATIS DI VIEW.
     */
    public function create()
    {
        // $kategoris = Kategori::all(); // BARIS INI TIDAK LAGI DIBUTUHKAN DI SINI
        return view('barang.create'); // Tidak perlu passing 'kategoris' lagi
    }

    /**
     * Menyimpan barang baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string', // Validasi 'kategori' sebagai string
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // Cari ID kategori berdasarkan nama kategori yang diterima dari form
        // Ini akan membuat atau mengambil kategori yang sudah ada
        $kategori = Kategori::firstOrCreate(
            ['nama_kategori' => $validatedData['kategori']]
            // Jika ada kolom lain yang wajib, tambahkan di sini. Contoh: ['nama_kategori' => $validatedData['kategori'], 'deskripsi' => 'Default']
        );

        // Buat data barang baru dengan kategori_id yang ditemukan/dibuat
        Barang::create([
            'nama_barang' => $validatedData['nama_barang'],
            'id_kategori' => $kategori->id, // Gunakan ID dari kategori yang ditemukan/dibuat
            'harga' => $validatedData['harga'],
            'stok' => $validatedData['stok'],
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit barang.
     * (Sama seperti sebelumnya, Anda akan membutuhkan $kategoris jika ingin dropdown/radio dynamic)
     * Jika Anda ingin radio button tetap statis di edit, maka hapus $kategoris dari sini juga.
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all(); // Pertahankan jika Anda ingin radio button kategori di form edit dynamic
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Mengupdate data barang di database.
     * (Mirip dengan store, Anda perlu mencari atau membuat kategori jika kategori di form edit juga statis)
     */
    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
        'nama_barang' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id', 
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
    ]);

    $barang->update([
        'nama_barang' => $validatedData['nama_barang'],
        'id_kategori' => $validatedData['kategori_id'], 
        'harga' => $validatedData['harga'],
        'stok' => $validatedData['stok'],
    ]);

    return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    /**
     * Menghapus data barang dari database.
     */
    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
            return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('barang.index')->with('error', 'Gagal menghapus barang. Mungkin ada data terkait.');
        }
    }
}