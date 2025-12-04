@extends('templates.app')

@section('content')
<div class="card w-50 d-block mx-auto my-5 p-4">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('orders.pdf', $order->id) }}" class="btn btn-secondary">Unduh (.pdf)</a>
        </div>

        <div class="w-100 mb-4">
            <h5 class="text-center mb-3">{{ $order->product->name }}</h5>
            <hr>

            <div class="d-flex justify-content-between mb-2">
                <span>Kategori</span>
                <span>{{ $order->product->category->name ?? '-' }}</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Tanggal</span>
                <span>{{ \Carbon\Carbon::parse($order->orderPayment->booked_date)->format('d F Y') }}</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Jumlah</span>
                <span>{{ $order->quantity }} pcs</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Harga Satuan</span>
                <span>Rp {{ number_format($order->product->price, 0, ',', '.') }}</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Biaya Pengiriman</span>
                <span>Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Promo</span>
                <span>
                    @if ($order->promo_id)
                        {{ $order->promo->type == 'percent' ? $order->promo->discount.'%' : 'Rp '.number_format($order->promo->discount,0,',','.') }}
                    @else
                        -
                    @endif
                </span>
            </div>

            <hr>

            <div class="d-flex justify-content-between total fw-bold">
                <span>Total Bayar</span>
                <span>Rp {{ number_format($order->total_price + $order->shipping_fee, 0, ',', '.') }}</span>
            </div>

            <p class="text-center mt-4 text-muted">Terima kasih telah berbelanja di Growith!</p>
        </div>
    </div>
</div>
@endsection
