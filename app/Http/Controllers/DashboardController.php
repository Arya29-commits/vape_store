<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Penjualan;
use App\Models\Barang;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $pendapatanHariIni = Penjualan::whereDate('created_at', $today)->sum('total_harga');
        $transaksiHariIni = Penjualan::whereDate('created_at', $today)->count();
        $totalProduk = Barang::count();
        $stokKritis = Barang::where('stok', '<', 10)->get();
        $jumlahStokKritis = $stokKritis->count();

        // Penjualan 7 hari terakhir
        $penjualan7Hari = Penjualan::selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
    ->whereDate('created_at', '>=', Carbon::now()->subDays(6))
    ->groupBy(DB::raw('DATE(created_at)'))
    ->orderBy(DB::raw('DATE(created_at)'))
    ->get();
        // Aktifitas terakhir
        $logPenjualan = Penjualan::latest()->take(3)->get()->map(function ($item) {
            return [
                'jenis' => 'penjualan',
                'keterangan' => "Penjualan #INV{$item->id}",
                'nominal' => $item->total_harga,
                'waktu' => $item->created_at
            ];
        });

        $logBarang = Barang::latest()->take(2)->get()->map(function ($item) {
            return [
                'jenis' => 'barang',
                'keterangan' => "Barang \"{$item->nama_barang}\" ditambahkan", // Pastikan nama field benar
                'nominal' => null,
                'waktu' => $item->created_at
            ];
        });

        $logAktivitas = $logPenjualan->merge($logBarang)->sortByDesc('waktu')->take(5);

        return view('dashboard', [
            'pendapatanHariIni' => $pendapatanHariIni,
            'transaksiHariIni' => $transaksiHariIni,
            'totalProduk' => $totalProduk,
            'stokKritis' => $stokKritis,
            'jumlahStokKritis' => $jumlahStokKritis,
            'penjualan7Hari' => $penjualan7Hari,
            'logAktivitas' => $logAktivitas
        ]);
    }
}