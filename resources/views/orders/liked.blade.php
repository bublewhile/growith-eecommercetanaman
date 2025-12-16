@extends('templates.app')

@section('title', 'Produk yang Disukai')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-success">Produk yang Kamu Sukai</h2>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm position-relative">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/default-product.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-truncate">{{ $product->name }}</h5>
                        <p class="text-muted mb-1">Kategori: {{ $product->category->name ?? '-' }}</p>
                        <p class="fw-bold text-success mb-2">Rp {{ number_format($product->price,0,',','.') }}</p>

                        <p class="card-text text-center bg-success py-2 mt-3">
                            <a href="{{ route('products.detail', $product->id) }}" class="text-white">
                                <b>Lihat Detail</b>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada produk yang kamu sukai.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
