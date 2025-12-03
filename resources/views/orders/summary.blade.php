@extends('templates.app')

@section('content')
<div class="container my-5">

    <div class="text-center mb-4">
        <h2 class="fw-bold">Ringkasan Order</h2>
    </div>

    {{-- Jika order tidak ditemukan --}}
    @if (!$order)
        <div class="alert alert-danger">Order tidak ditemukan.</div>
        <a href="/products" class="btn btn-success">Kembali</a>
    @endif

    {{-- Jika product hilang --}}
    @if ($order && !$order->product)
        <div class="alert alert-warning">Produk untuk order ini sudah dihapus.</div>
    @endif

    @if ($order && $order->product)
    <div class="card shadow-sm p-4">

        {{-- Bagian poster + detail kiri --}}
        <div class="row">
            {{-- Poster --}}
            <div class="col-md-3 d-flex justify-content-center">
                <img src="{{ $order->product->image ? asset('storage/' . $order->product->image) : 'https://via.placeholder.com/250x350?text=Product' }}"
                     class="img-fluid rounded shadow-sm"
                     style="max-height: 320px; object-fit: cover;">
            </div>

            {{-- Detail produk --}}
            <div class="col-md-9">
                <h4 class="fw-bold">{{ $order->product->name }}</h4>

                <div class="mt-3">
                    <p><strong>Merek:</strong> {{ $order->product->brand ?? '-' }}</p>
                    <p><strong>Kategori:</strong> {{ $order->product->category->name ?? '-'}}</p>
                    <p><strong>Harga Satuan:</strong> Rp {{ number_format($order->product->price, 0, ',', '.') }}</p>
                    <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
                    <p><strong>Ukuran:</strong> {{ $order->size ?? '-' }}</p>
                    <p><strong>Material Pot:</strong> {{ $order->pot_material ?? '-' }}</p>
                    <p><strong>Warna Pot:</strong> {{ $order->pot_color ?? '-' }}</p>
                    <p><strong>Total Harga:</strong>
                        <span class="text-success fw-bold">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <hr class="my-4">

        {{-- Detail Transaksi --}}
        <h5 class="fw-bold mb-3">Detail Transaksi</h5>
        <div class="row mb-2">
            <div class="col-6">Qty</div>
            <div class="col-6 fw-bold">: {{ $order->quantity }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-6">Harga Satuan</div>
            <div class="col-6 fw-bold">: Rp {{ number_format($order->product->price, 0, ',', '.') }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-6">Total Harga</div>
            <div class="col-6 fw-bold text-success">: Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
        </div>

        <hr class="my-4">

        {{-- Detail Alamat User --}}
        <h5 class="fw-bold mb-3">Alamat Pengiriman</h5>
        <div class="border rounded p-3 mb-3">
            <p><strong>Nama:</strong> {{ auth()->user()->nama_lengkap }}</p>
            <p><strong>Alamat:</strong> {{ auth()->user()->alamat }}, {{ auth()->user()->kota }}, {{ auth()->user()->provinsi }} ({{ auth()->user()->kode_pos }})</p>
            <p><strong>No. HP:</strong> {{ auth()->user()->no_hp }}</p>
        </div>

        <hr class="my-4">

        {{-- Pilihan Promo --}}
        <h5 class="fw-bold mb-3">Pilih Promo</h5>
        <select id="promo_id" class="form-select mb-3">
            <option value="">Pilih</option>
            @foreach ($promos as $promo)
                <option value="{{ $promo->id }}">
                    {{ $promo->promo_code }} -
                    {{ $promo->type == 'percent' ? $promo->discount . '%' : 'Rp ' . number_format($promo->discount, 0, ',', '.') }}
                </option>
            @endforeach
        </select>

        @if ($promos->count() == 0)
            <p class="text-muted">Tidak ada promo aktif.</p>
        @endif

        {{-- Pilih Metode Pembayaran --}}
        <h5 class="fw-bold mb-3">Pilih Metode Pembayaran</h5>
        <select id="payment_method" class="form-select mb-3" required>
            <option value="" selected disabled>Pilih Metode</option>
            <option value="cod">COD (Bayar di Tempat)</option>
            <option value="bank_bri">Transfer BANK BRI</option>
        </select>

        {{-- Tombol Bayar Sekarang --}}
        <div class="text-center mt-4">
            <button class="btn btn-success px-5 fw-bold" onclick="createInvoice('{{ $order->id }}')">
                BAYAR SEKARANG
            </button>
        </div>

    </div>
    @endif
</div>
@endsection

@push('script')
<script>
    function createInvoice(orderId) {
        let promo = $("#promo_id").val();
        let paymentMethod = $("#payment_method").val();

        if (!paymentMethod) {
            alert("Silakan pilih metode pembayaran terlebih dahulu.");
            return;
        }

        $.ajax({
            url: "{{ route('orders.invoice', ['orderId' => ':id']) }}".replace(':id', orderId),
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                promo_id: promo,
                payment_method: paymentMethod
            },
            success: function(response) {
                window.location.href = `/orders/${orderId}/payment`;
            },
            error: function(message) {
                console.log(message);
                alert('Gagal membuat invoice pembayaran');
            }
        });
    }
</script>
@endpush
