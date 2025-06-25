@extends('layouts.app')
@section('title', 'Input Penjualan')

@section('content')
<h2>Input Penjualan - Pilih Barang</h2>
<div class="grid-container">
    @foreach ($barangs as $barang)
        <div class="card">
            <h4>{{ $barang->nama }}</h4>
            <p>Harga: Rp{{ number_format($barang->harga) }}</p>
            <form method="POST" action="/keranjang/tambah">
                @csrf
                <input type="hidden" name="id" value="{{ $barang->id }}">
                <input type="hidden" name="nama" value="{{ $barang->nama }}">
                <input type="hidden" name="harga" value="{{ $barang->harga }}">
                <input type="number" name="jumlah" min="1" max="{{ $barang->stok }}" required>
                <button type="submit">Tambah ke Keranjang</button>
            </form>
        </div>
    @endforeach
</div>
<a href="/keranjang" class="btn btn-success mt-3">Lihat Keranjang</a>

<style>
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
}
.card {
    border: 1px solid #ccc;
    padding: 12px;
    border-radius: 8px;
    background-color: #f9f9f9;
}
</style>
@endsection
