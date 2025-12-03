<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growith - Orders by Status</title>
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/aos/aos.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/loader.js')}}"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <nav aria-label="breadcrumb w-100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('staff.orders.index')}}">Orders</a></li>
                    <li class="breadcrumb-item"><a href="{{route('staff.orders.status')}}">By Status</a></li>
                    <li class="breadcrumb-item"><a href="{{route('logout')}}">Logout</a></li>

                </ol>
            </nav>
        </div>
        <form class="input-group w-50 m-auto" method="GET" action="">
            <select name="status" class="form-control" style="height: 55px !important">
                <option selected hidden disabled>Filter Status Order</option>
                <option value="pending">Pending</option>
                <option value="paid">Sudah Dibayar</option>
                <option value="shipped">Dikirim</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
            <button type="submit" class="btn btn-outline-success mb-4 pb-2 mt-2">Cari</button>
            <div>
                <a href="{{ route('staff.orders.status') }}" class="btn btn-outline-secondary mt-2">Refresh</a>
            </div>
        </form>
    </nav>

    <div class="px-5 my-3">
        @if (Session::get('response'))
            <div class="alert alert-success my-3">
                {{Session::get('response')}}
            </div>
        @endif

        <table class="table table-hover table-fixed">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Customer</th>
                    <th>Email</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Alamat Pengiriman</th>
                    <th>Updated At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $status = request()->get('status') ?? '';
                    $no = 1;
                @endphp
                @foreach ($orders as $order)
                    @if ($status === '' || $order->status == $status)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $order->user->nama_lengkap ?? '-' }}</td>
                            <td>{{ $order->user->email ?? '-' }}</td>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->user->alamat ?? '-' }}</td>
                            <td>{{ $order->updated_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{route('orders.edit', $order->id)}}" class="btn btn-success">Ubah Status</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{asset('assets/vendors/popper.js/popper.min.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/vendors/aos/aos.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        AOS.init({ duration: 2000 });
    </script>
</body>
</html>
