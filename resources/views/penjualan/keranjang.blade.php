@extends('layouts.app')
@section('title', 'Keranjang Penjualan')

@section('content')
<h2>Konfirmasi Penjualan</h2>

@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<table border="1" cellpadding="8" width="100%">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach ($keranjang as $item)
            <tr>
                <td>{{ $item['nama'] }}</td>
                <td>Rp{{ number_format($item['harga']) }}</td>
                <td>{{ $item['jumlah'] }}</td>
                <td>Rp{{ number_format($item['subtotal']) }}</td>
                @php $total += $item['subtotal']; @endphp
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total: Rp{{ number_format($total) }}</strong></p>

<form method="POST" action="/penjualan/simpan">
    @csrf
    <label>Nama Pelanggan (Opsional):</label>
    <input type="text" name="nama_pelanggan" value="Umum">
    <button type="submit">Simpan Penjualan</button>
</form>
@endsection
