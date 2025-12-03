@extends('templates.app')

@section('content')
    <div class="container py-5">
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }} <b>Selamat Datang, {{ Auth::user()->name }}</b>
            </div>
        @endif
        <h3 class="fw-bold text-success mb-4">Admin Dashboard 🌱</h3>

        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }} <b>{{ Auth::user()->name }}</b>!
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-seedling fa-2x text-success mb-3"></i>
                        <h5>Total Produk</h5>
                        <h3 class="fw-bold text-success">{{ $totalProduk ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-users fa-2x text-success mb-3"></i>
                        <h5>Total Pengguna</h5>
                        <h3 class="fw-bold text-success">{{ $totalUser ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h5 class="my-3">Grafik Pembelian Produk</h5>
        <div class="row">
            <div class="col-6">
                <h5>Data Pembelian Produk Bulan {{ now()->format('F') }}</h5>
                <canvas id="chartBar"></canvas>
            </div>
            <div class="col-6">
                <h5>Data Produk Berdasarkan Status</h5>
                <canvas id="chartPie" class="w-50 h-75 ps-5"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let labelBar = [];
        let dataBar = [];
        let labelPie = [];
        let dataPie = [];

        $(function() {
            // Chart Bar: Orders
            $.ajax({
                url: "{{ route('admin.orders.chart') }}",
                method: "GET",
                success: function(response) {
                    labelBar = response.labels;
                    dataBar = response.data;
                    chartBar();
                },
                error: function(err) {
                    alert('Gagal mengambil data untuk chart Bar!')
                }
            });

            // Chart Pie: Products
            $.ajax({
                url: "{{ route('admin.products.chart') }}",
                method: "GET",
                success: function(response) {
                    labelPie = response.labels;
                    dataPie = response.data;
                    chartPie();
                },
                error: function(err) {
                    alert('Gagal mengambil data untuk chart Pie!')
                }
            });
        });

        // Chart Bar
        const ctx = document.getElementById('chartBar');

        function chartBar() {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelBar,
                    datasets: [{
                        label: 'Penjualan Produk Bulan Ini',
                        data: dataBar,
                        borderWidth: 1,
                        backgroundColor: 'rgba(46, 125, 50, 0.6)'
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
        }

        // Chart Pie
        const ctx2 = document.getElementById('chartPie');

        function chartPie() {
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: labelPie,
                    datasets: [{
                        label: 'Data Produk Berdasarkan Status',
                        data: dataPie,
                        backgroundColor: [
                            'rgb(76, 175, 80)', // hijau untuk aktif
                            'rgb(244, 67, 54)' // merah untuk nonaktif
                        ],
                        hoverOffset: 4
                    }]
                }
            })
        }
    </script>
@endpush
