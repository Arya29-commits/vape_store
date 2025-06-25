@extends('layouts.app')
@section('title', 'Tambah Barang Baru')

@section('content')
    <div class="page-header">
        <h1>Tambah Barang Baru</h1>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops! Ada yang salah dengan input Anda.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="form-container">
        <form action="{{ route('barang.store') }}" method="POST">
            {{-- Token keamanan Laravel, wajib ada di setiap form --}}
            @csrf 
            
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
    <label>Kategori</label> {{-- Label umum untuk grup --}}
    <div class="radio-group-container">

        <div class="radio-option">
            <input type="radio" id="cat_device" name="kategori" value="Device" required>
            <label for="cat_device">Device</label>
        </div>

        <div class="radio-option">
            <input type="radio" id="cat_catridge" name="kategori" value="Catridge">
            <label for="cat_catridge">Catridge</label>
        </div>

        <div class="radio-option">
            <input type="radio" id="cat_liquid" name="kategori" value="Liquid">
            <label for="cat_liquid">Liquid</label>
        </div>

        <div class="radio-option">
            <input type="radio" id="cat_coil" name="kategori" value="Coil">
            <label for="cat_coil">Coil</label>
        </div>

        <div class="radio-option">
            <input type="radio" id="cat_kapas" name="kategori" value="Kapas">
            <label for="cat_kapas">Kapas</label>
        </div>

        <div class="radio-option">
            <input type="radio" id="cat_baterai" name="kategori" value="Baterai">
            <label for="cat_baterai">Baterai</label>
        </div>

    </div>
</div>
             <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" class="form-control" required>
            </div>
             <div class="form-group">
                <label for="stok">Stok Awal</label>
                <input type="number" id="stok" name="stok" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i> Simpan Barang
            </button>
        </form>
    </div>
@endsection