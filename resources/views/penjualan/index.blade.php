@extends('layouts.app') {{-- Pastikan 'layouts.app' adalah path yang benar ke layout master Anda --}}

@section('content')
<div class="container-fluid"> {{-- Menggunakan container-fluid untuk lebar penuh seperti di dashboard --}}
    <h1 class="h3 mb-4 text-gray-800">Daftar Penjualan</h1> {{-- Heading halaman --}}

    {{-- Card untuk membungkus tabel --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6> {{-- Judul di header card --}}
        </div>
        <div class="card-body"> {{-- Body dari card --}}
            <div class="table-responsive"> {{-- Penting untuk tabel agar responsif di layar kecil --}}
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> {{-- Kelas Bootstrap untuk tabel --}}
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    {{-- Opsional: Tambahkan <tfoot> jika Anda ingin menggunakan DataTables.js --}}
                    {{-- <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @forelse($penjualans as $index => $penjualan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $penjualan->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td> {{-- Menggunakan null coalescing operator --}}
                                <td>{{ $penjualan->jumlah }}</td>
                                <td>Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $penjualan->pelanggan ?? 'Umum' }}</td> {{-- Menampilkan data pelanggan --}}
                                <td>{{ $penjualan->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data penjualan.</td> {{-- Sesuaikan colspan --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection