@extends('templates.app')

@section('content')
<section class="text-center fade-in py-5 bg-white">
    <h2 class="fw-normal" style="font-family:'Playfair Display'; font-size:1.5rem; color:#2c2c54;">
        Produk Kategori: {{ $category->name }}
    </h2>
    <hr class="mx-auto mt-3 mb-5" style="width:100px; border:1px solid #2c2c54;">

    <div class="container">
        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-0 h-100">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @if (!empty($product->discount))
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">{{ $product->discount }}</span>
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-2">{{ $product->name }}</h6>
                            <p class="fw-bold mb-0 text-success">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                @if (!empty($product->old_price))
                                    <span class="text-muted text-decoration-line-through">
                                        Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada produk di kategori ini.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
