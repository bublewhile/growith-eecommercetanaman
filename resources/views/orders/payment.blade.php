@extends('templates.app')

@section('content')
<div class="container card my-5 p-4">
    <div class="card-body">
        <h5 class="text-center mb-4">Selesaikan Pembayaran</h5>

        {{-- QR Code --}}
        <img src="{{ asset('storage/' . $order->orderPayment->barcode) }}" class="d-block mx-auto mb-4" style="max-width: 300px;">

        <div class="w-75 d-block mx-auto">

            {{-- Detail Produk --}}
            <div class="d-flex justify-content-between mb-2">
                <p>Produk</p>
                <p><b>{{ $order['product']['name'] }}</b></p>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <p>Jumlah</p>
                <p><b>{{ $order['quantity'] }}</b></p>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <p>Harga Satuan</p>
                <p><b>Rp. {{ number_format($order['product']['price'], 0, ',', '.') }}</b></p>
            </div>

            {{-- Biaya Layanan --}}
            <div class="d-flex justify-content-between mb-2">
                <p>Biaya Layanan</p>
                <p><b>Rp. {{ number_format($order['shipping_fee'], 0, ',', '.') }}</b></p>
            </div>

            {{-- Promo --}}
            <div class="d-flex justify-content-between mb-2">
                <p>Promo</p>
                @if ($order['promo_id'] != null)
                    <p><b>
                        {{ $order['promo']['type'] == 'percent'
                            ? $order['promo']['discount'] . '%'
                            : 'Rp. ' . number_format($order['promo']['discount'], 0, ',', '.') }}
                    </b></p>
                @else
                    <p><b>-</b></p>
                @endif
            </div>

            <hr>

            {{-- Total Harga --}}
            <div class="d-flex justify-content-end mb-3">
                @php
                    $total = $order['total_price'] + $order['shipping_fee'];
                @endphp
                <h5>Total: Rp. {{ number_format($total, 0, ',', '.') }}</h5>
            </div>

            {{-- Tombol Konfirmasi Pembayaran --}}
            <form action="{{ route('orders.proof', $order->id) }}" method="post">
                @csrf
                @method('PATCH')
                <button class="btn btn-success btn-lg btn-block">Sudah Dibayar</button>
            </form>

        </div>
    </div>
</div>
@endsection
