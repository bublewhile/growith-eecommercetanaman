@extends('templates.app')

@section('title', $product->name)

@section('content')
    <style>
        .thumb-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 8px;
            border: 2px solid transparent;
        }

        .thumb-img.active {
            border-color: #198754;
        }

        .tab-btn {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
        }

        .tab-btn.active {
            color: #198754;
            border-bottom: 2px solid #198754;
        }
    </style>

    <div class="container py-5">

        {{-- Breadcrumb --}}
        <p class="text-muted mb-4">
            Home / {{ $product->category->name ?? 'Kategori' }} / <strong>{{ $product->name }}</strong>
        </p>

        <div class="row g-5">
            {{-- LEFT: Gambar --}}
            <div class="col-md-6">
                <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm mb-3"
                    alt="{{ $product->name }}">

                <div class="d-flex gap-2">
                    <img src="{{ asset('storage/' . $product->image) }}" class="thumb-img active"
                        onclick="changeImage(this)">
                    @foreach ($product->gallery ?? [] as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="thumb-img" onclick="changeImage(this)">
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Detail --}}
            <div class="col-md-6">
                <h2 class="fw-bold text-success">{{ $product->name }}</h2>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">New</span>
                    <span class="text-warning">★★★★★ ({{ number_format($product->rating ?? 4.5, 1) }})</span>
                    <span class="text-muted">• {{ $product->reviews_count ?? 420 }} Reviews</span>
                </div>

                <h3 class="mt-3 fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                <p class="text-muted">Kategori: {{ $product->category->name ?? '-' }}</p>
                <p class="text-muted">Stok: {{ $product->stock }}</p>
                <p class="mb-4">{{ $product->description ?? 'Tidak ada deskripsi produk.' }}</p>

                {{-- Form Pembelian --}}
                @auth
                    <form action="{{ route('orders.create', ['productId' => $product->id]) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="size" class="form-label">Ukuran Tanaman</label>
                            <select name="size" id="size" class="form-select" required>
                                <option value="" disabled selected>Pilih ukuran</option>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pot_material" class="form-label">Material Pot</label>
                            <select name="pot_material" id="pot_material" class="form-select" required>
                                <option value="" disabled selected>Pilih material</option>
                                <option value="plastic">Plastic</option>
                                <option value="wood">Wood</option>
                                <option value="metal">Metal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pot_color" class="form-label">Warna Pot</label>
                            <select name="pot_color" id="pot_color" class="form-select" required>
                                <option value="" disabled selected>Pilih warna</option>
                                <option value="grey">Grey</option>
                                <option value="white">White</option>
                                <option value="green">Green</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 mt-3 align-items-center">
                            <a href="{{ route('home.products.all') }}" class="btn btn-outline-secondary">← Kembali</a>

                            <button type="button" class="btn btn-outline-success"
                                onclick="document.getElementById('likeForm').submit()">
                                @if ($product->likedBy->contains(auth()->id()))
                                    <i class="fa-solid fa-heart text-danger"></i>
                                @else
                                    <i class="fa-regular fa-heart"></i>
                                @endif

                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fa-solid fa-cart-plus"></i> Beli Sekarang
                                </button>
                        </div>
                    </form>
                    <form id="likeForm" action="{{ route('products.like', $product->id) }}" method="POST"
                        style="display:none;">
                        @csrf
                    </form>

                @endauth

                <p class="mt-3"><strong>SKU:</strong> {{ $product->sku ?? 'PCTG-87421' }}</p>
            </div>
        </div>

        {{-- TAB MENU --}}
        <div class="mt-5">
            <div class="d-flex gap-4 border-bottom pb-2">
                <span class="tab-btn active" onclick="openTab('desc', this)">Deskripsi</span>
                <span class="tab-btn" onclick="openTab('info', this)">Informasi Tambahan</span>
                <span class="tab-btn" onclick="openTab('rev', this)">Review</span>
            </div>

            <div id="tab-desc" class="mt-4">
                <p>{{ $product->description ?? 'Tidak ada deskripsi tambahan.' }}</p>
            </div>

            <div id="tab-info" class="mt-4 d-none">
                <ul>
                    <li>Material: Plastik / Ceramic / Metal</li>
                    <li>Size: Medium / Large</li>
                    <li>Color: Grey / White / Green</li>
                </ul>
            </div>

            <div id="tab-rev" class="mt-4 d-none">
                <h5 class="fw-bold text-success">Komentar Pembeli</h5>

                @auth
                    <form action="{{ route('products.comment', $product->id) }}" method="POST" class="mb-4">
                        @csrf
                        <textarea name="comment" class="form-control" rows="3" placeholder="Tulis komentar..." required></textarea>
                        <button class="btn btn-success mt-2">Kirim</button>
                    </form>
                @endauth

                @foreach ($product->comments as $comment)
                    <div class="border-bottom pb-2 mb-3">
                        <strong>{{ $comment->user->name }}</strong>
                        <small class="text-muted">• {{ $comment->created_at->format('d M Y') }}</small>
                        <p class="mt-1">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- RELATED PRODUCTS --}}
        <div class="mt-5 pt-4">
            <h3 class="fw-bold text-success mb-4">Explore Related Products</h3>

            <div class="row g-4">
                @foreach ($relatedProducts as $rel)
                    <div class="col-md-3">
                        <a href="{{ route('products.detail', $rel->id) }}" class="text-decoration-none text-dark">
                            <div class="card shadow-sm border-0">
                                <img src="{{ asset('storage/' . $rel->image) }}" class="card-img-top" alt="">
                                <div class="card-body">
                                    <h6 class="fw-bold">{{ $rel->name }}</h6>
                                    <p class="text-success fw-bold">Rp {{ number_format($rel->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function changeImage(el) {
            document.getElementById("mainImage").src = el.src;
            document.querySelectorAll(".thumb-img").forEach(i => i.classList.remove("active"));
            el.classList.add("active");
        }

        function openTab(tab, btn) {
            document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            document.getElementById("tab-desc").classList.add("d-none");
            document.getElementById("tab-info").classList.add("d-none");
            document.getElementById("tab-rev").classList.add("d-none");

            document.getElementById("tab-" + tab).classList.remove("d-none");
        }
    </script>
@endsection
