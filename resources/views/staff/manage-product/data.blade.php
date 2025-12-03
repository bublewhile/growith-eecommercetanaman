@extends('templates.app')

@section('content')
    <style>
        body {
            font-family: 'Lora', serif;
        }

        .growith-wrapper {
            background: #f4f7f2;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            animation: fadeIn 0.4s ease;
        }

        h2.growith-title {
            font-size: 26px;
            font-weight: 700;
            color: #2e7d32;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2.growith-title::before {
            content: "📋";
            font-size: 24px;
        }

        .growith-table th {
            background: #e9f5ec;
            color: #2e7d32;
            font-weight: 600;
        }

        .growith-table td {
            vertical-align: middle;
        }

        .badge-growith {
            padding: 4px 8px;
            border-radius: 5px;
            font-weight: 400;
            min-width: 90px;
            text-align: center;
            font-family: 'Lora', serif;
            color: #fff !important;
        }

        .badge-pending {
            background-color: #e8b75a !important;
        }

        .badge-processed {
            background-color: #5cbad1 !important;
        }

        .badge-shipped {
            background-color: #4a8fe7 !important;
        }

        .badge-success {
            background-color: #6db87f !important;
        }

        .btn-growith {
            background: #2e7d32;
            color: #fff;
            border-radius: 10px;
            padding: 6px 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-growith:hover {
            background: #256628;
            color: #fff;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container my-5 growith-wrapper">
        <h2 class="growith-title">Kelola Pesanan</h2>

        <form class="input-group mb-4" method="GET" action="">
            <input type="search" class="form-control rounded" placeholder="Cari pesanan..." name="search" />
            <button type="submit" class="btn btn-outline-success">Search</button>
            <a href="{{ route('staff.orders.index') }}" class="btn btn-outline-secondary ms-2">Refresh</a>
        </form>

        <table class="table table-hover growith-table shadow-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $order->user->nama_lengkap }}</td>
                        <td>{{ $order->user->email }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span
                                class="badge-growith
                        @if ($order->status == 'pending') bg-warning
                        @elseif($order->status == 'processed') bg-info
                        @elseif($order->status == 'shipped') bg-primary
                        @else bg-success @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('staff.response.edit', $order->id) }}" class="btn btn-success w-100">
                                Update
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
