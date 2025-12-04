<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Order</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        .wrapper {
            width: 450px;
            margin: 20px auto;
            border: 1px solid #eaeaea;
            border-radius: 6px;
            padding: 2rem;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 15px;
        }
        .barcode {
            display: block;
            margin: 20px auto;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Growith Order</h2>
        <div style="text-align:center; margin: 20px 0;">
            <img src="{{ base_path('public/storage/' . $order->orderPayment->barcode) }}" class="barcode">
        </div>

        <div class="row">
            <span>Nama Penerima</span>
            <span>{{ $order->user->nama_lengkap ?? '-' }}</span>
        </div>

        <div class="row">
            <span>Alamat</span>
            <span>{{ $order->user->alamat ?? '-' }}, {{ $order->user->kota ?? '-' }}, {{ $order->user->provinsi ?? '-' }}</span>
        </div>

        <div class="row">
            <span>No. HP</span>
            <span>{{ $order->user->no_hp ?? '-' }}</span>
        </div>

        <hr>
        <div class="row">
            <span>Produk</span>
            <span>{{ $order->product->name }}</span>
        </div>

        <div class="row">
            <span>Jumlah</span>
            <span>{{ $order->quantity }}</span>
        </div>

        <div class="row">
            <span>Harga Satuan</span>
            <span>Rp {{ number_format($order->product->price, 0, ',', '.') }}</span>
        </div>

        <div class="row">
            <span>Biaya Layanan</span>
            <span>Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
        </div>

        <div class="row">
            <span>Promo</span>
            <span>
                @if ($order->promo_id)
                    {{ $order->promo->type == 'percent' ? $order->promo->discount . '%' : 'Rp ' . number_format($order->promo->discount, 0, ',', '.') }}
                @else
                    -
                @endif
            </span>
        </div>

        <hr>

        @php
            $total = $order->total_price + $order->shipping_fee;
        @endphp
        <div class="total">
            Total: Rp {{ number_format($total, 0, ',', '.') }}
        </div>

        <p style="text-align:center; margin-top:20px;">Terima kasih telah berbelanja di Growith!</p>
    </div>
</body>
</html>
