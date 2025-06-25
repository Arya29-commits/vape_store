@extends('layouts.app')
@section('title', 'Input Pembelian')

@section('content')
    <h1>Input Pembelian</h1>

    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf
        <div>
            <label>Supplier:</label>
            <select name="supplier_id" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>No. Faktur:</label>
            <input type="text" name="no_faktur" required>
        </div>

        <div>
            <label>Tanggal:</label>
            <input type="date" name="tanggal" required>
        </div>

        <div>
            <label>Total:</label>
            <input type="number" name="total" step="0.01" required>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
