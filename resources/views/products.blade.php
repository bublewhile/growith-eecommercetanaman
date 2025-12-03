@extends('templates.app')

@section('content')
<div class="container my-5">
    <h5 class="mb-5">Produk Terbaru</h5>

    <form action="" method="GET">
        <div class="row">
            <div class="col-10">
                <input type="text" class="form-control" placeholder="Cari produk..." name="search_product">
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-success">Cari</button>
            </div>
        </div>
    </form>

    <div class="d-flex justify-content-center flex-wrap gap-4 my-3">
        @foreach ($products as $item)
        <div class="card" style="width: 18rem">
            <img src="{{ asset('storage/' . $item->image) }}"
                 style="height: 250px; object-fit: cover"
                 class="card-img-top"
                 alt="{{ $item->name }}" />

            <div class="card-body">
                <h6 class="card-title text-center">{{ $item->name }}</h6>
                <p class="text-center text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                <p class="card-text text-center bg-success py-2">
                    <a href="{{ route('products.detail', $item->id) }}" class="text-white">
                        <b>Lihat Detail</b>
                    </a>
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
