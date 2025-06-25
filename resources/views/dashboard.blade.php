@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 font-bold text-xl">Dashboard</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 bg-white rounded-xl shadow">
            <p class="text-gray-500">Pendapatan Hari Ini</p>
            <h3 class="text-xl font-bold text-blue-600">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
        </div>
        <div class="p-4 bg-white rounded-xl shadow">
            <p class="text-gray-500">Transaksi Hari Ini</p>
            <h3 class="text-xl font-bold text-green-600">{{ $transaksiHariIni }}</h3>
        </div>
        <div class="p-4 bg-white rounded-xl shadow">
            <p class="text-gray-500">Total Produk</p>
            <h3 class="text-xl font-bold text-yellow-600">{{ $totalProduk }}</h3>
        </div>
        <div class="p-4 bg-white rounded-xl shadow">
            <p class="text-gray-500">Stok Kritis</p>
            <h3 class="text-xl font-bold text-red-600">{{ $jumlahStokKritis }} Produk</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="md:col-span-2 p-4 bg-white rounded-xl shadow">
            <h3 class="mb-2 font-semibold">Grafik Penjualan (7 Hari Terakhir)</h3>
            <canvas id="penjualanChart" height="120"></canvas>
        </div>
        <div class="p-4 bg-white rounded-xl shadow">
            <h3 class="mb-2 font-semibold">Aktivitas Terakhir</h3>
            <ul class="space-y-2 text-sm">
                @foreach($logAktivitas as $log)
                    <li class="flex justify-between items-center border-b pb-1">
                        <span>{{ $log['keterangan'] }}</span>
                        @if($log['nominal'])
                            <span class="text-green-600">Rp {{ number_format($log['nominal'], 0, ',', '.') }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($penjualan7Hari->pluck('tanggal')->map(fn($t) => \Carbon\Carbon::parse($t)->format('d M'))) !!};
    const data = {!! json_encode($penjualan7Hari->pluck('total')) !!};

    const ctx = document.getElementById('penjualanChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush