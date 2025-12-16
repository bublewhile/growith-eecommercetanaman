@extends('templates.app')

@section('title', 'Produk Kategori: '.$category->name)

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-success">Produk Kategori: {{ $category->name }}</h2>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm position-relative">
                    {{-- Gambar produk --}}
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/default-product.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif

                    <div class="card-body d-flex flex-column">
                        {{-- Nama produk --}}
                        <h5 class="card-title fw-bold text-truncate">{{ $product->name }}</h5>

                        {{-- Nama kategori --}}
                        <p class="text-muted mb-1">Kategori: {{ $product->category->name ?? '-' }}</p>

                        {{-- Harga produk --}}
                        <p class="fw-bold text-success mb-2">
                            Rp {{ number_format($product->price,0,',','.') }}
                            @if(!empty($product->old_price))
                                <span class="text-muted text-decoration-line-through">
                                    Rp {{ number_format($product->old_price,0,',','.') }}
                                </span>
                            @endif
                        </p>

                        {{-- Tombol detail --}}
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
                <p class="text-muted">Belum ada produk di kategori ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
