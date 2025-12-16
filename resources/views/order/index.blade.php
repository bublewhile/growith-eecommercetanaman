@extends('templates.app')

@section('content')
<div class="container card my-5 p-4">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-tab-pane"
                    type="button" role="tab" aria-controls="active-tab-pane" aria-selected="true">
                    Pesanan Aktif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="expired-tab" data-bs-toggle="tab" data-bs-target="#expired-tab-pane"
                    type="button" role="tab" aria-controls="expired-tab-pane" aria-selected="false">
                    Pesanan Kadaluarsa
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            {{-- Pesanan Aktif --}}
            <div class="tab-pane fade show active" id="active-tab-pane" role="tabpanel" aria-labelledby="active-tab">
                <h5 class="my-4">Data Pesanan Aktif, {{ Auth::user()->name }}</h5>
                <div class="d-flex flex-wrap">
                    @forelse ($ordersActive as $order)
                        <div class="w-30 me-4 p-4 my-3" style="border: 1px solid #eaeaea; border-radius: 5px">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <b>{{ $order->product->name ?? '-' }}</b>
                                </div>
                                <div>
                                    <h6 class="m-0 text-success">Aktif</h6>
                                </div>
                            </div>
                            <hr>
                            <div class="order-body text-start">
                                <p class="order-title mb-1">{{ $order->product->category->name ?? '-' }}</p>
                                <div class="order-details">
                                    <small>Tanggal Pesan: </small>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }} <br>
                                    <small>Jumlah: </small>{{ $order->quantity }} <br>
                                    @php
                                        $price = $order->total_price + $order->shipping_fee;
                                    @endphp
                                    <small>Total Bayar: </small> Rp. {{ number_format($price, 0, ',', '.') }}
                                </div>
                                <br>
                                <a href="{{ route('orders.pdf', $order->id) }}" class="btn btn-secondary">
                                    Unduh Invoice
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada pesanan aktif.</p>
                    @endforelse
                </div>
            </div>

            {{-- Pesanan Kadaluarsa --}}
            <div class="tab-pane fade" id="expired-tab-pane" role="tabpanel" aria-labelledby="expired-tab">
                <h5 class="my-4">Data Pesanan Kadaluarsa, {{ Auth::user()->name }}</h5>
                <div class="d-flex flex-wrap">
                    @forelse ($ordersExpired as $order)
                        <div class="w-25 me-4 p-4" style="border: 1px solid #eaeaea; border-radius: 5px">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <b>{{ $order->product->name ?? '-' }}</b>
                                </div>
                                <div>
                                    <h6 class="m-0 text-danger">Kadaluarsa</h6>
                                </div>
                            </div>
                            <hr>
                            <div class="order-body text-start">
                                <p class="order-title mb-1">{{ $order->product->category->name ?? '-' }}</p>
                                <div class="order-details">
                                    <small>Tanggal Pesan: </small>
                                    <b class="text-danger">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</b><br>
                                    <small>Jumlah: </small>{{ $order->quantity }} <br>
                                    @php
                                        $price = $order->total_price + $order->shipping_fee;
                                    @endphp
                                    <small>Total Bayar: </small> Rp. {{ number_format($price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada pesanan kadaluarsa.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
