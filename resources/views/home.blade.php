@extends('templates.app')

@section('content')
    <style>
        .fade-in {
            animation: fadeIn 1s ease-in forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .home-btn-wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            font-family: 'Playfair Display', serif;
        }

        .home-btn-wrapper h1 {
            font-size: 3rem;
            font-weight: 400;
            color: #fff !important;
        }

        .home-btn-wrapper em {
            font-style: italic;
            font-weight: 400;
        }

        .home-btn-wrapper .btn {
            margin-top: 60px;
            background: white;
            color: black;
            border-radius: 0;
            font-weight: 600;
            padding: 10px 25px;
            transition: 0.3s;
        }

        .home-btn-wrapper .btn:hover {
            background: white;
            color: black;
        }
    </style>

    <div class="bg-image position-relative" style="height:100vh; overflow:hidden;">
        <img src="{{ asset('image/home.jpeg') }}" class="w-100 h-100" style="object-fit:cover;" alt="Home Image">

        <div class="home-btn-wrapper">
            <h1>Bring <em>nature</em> home.</h1>
            <a href="{{ route('home') }}#products" class="btn btn-light">SHOP NOW</a>
        </div>
    </div>

    <section class="text-center fade-in py-5 bg-white">
        <h2 class="fw-normal" style="font-family:'Playfair Display', serif; font-size:1.5rem; color:#2c2c54;">
            Welcome to <span class="fw-bold text-success">GROWITH</span>
        </h2>

        <hr class="mx-auto mt-2" style="width:100px; border:1px solid #2c2c54;">

        <p class="mx-auto mt-3"
            style="max-width:680px; color:#4b4b6f; font-family:'Lora', serif; font-size:.95rem; line-height:1.6;">
            We bring <em>nature's</em> timeless charm into your home — a sanctuary of freshness, comfort, and peaceful
            living.
        </p>

        <div class="container mt-5">
            <div class="row justify-content-center text-center">

                <div class="col-md-3 col-10 mb-4">
                    <i class="fas fa-truck fa-2x text-success mb-3"></i>
                    <h6 class="fw-bold">Free Delivery</h6>
                    <p class="text-muted small">Free shipping for selected orders</p>
                </div>

                <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
                    <div class="vr" style="height:50px;"></div>
                </div>

                <div class="col-md-3 col-10 mb-4">
                    <i class="fas fa-credit-card fa-2x text-success mb-3"></i>
                    <h6 class="fw-bold">Secure Payment</h6>
                    <p class="text-muted small">Guaranteed safe with trusted payment methods</p>
                </div>

                <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
                    <div class="vr" style="height:50px;"></div>
                </div>

                <div class="col-md-3 col-10 mb-0">
                    <i class="fas fa-undo fa-2x text-success mb-3"></i>
                    <h6 class="fw-bold">Easy Return</h6>
                    <p class="text-muted small">Hassle-free returns within 30 days</p>
                </div>

            </div>
        </div>
    </section>

    <section class="text-center fade-in py-5 bg-white">
        <h2 id="products" class="fw-normal" style="font-family:'Playfair Display'; font-size:1.5rem; color:#2c2c54;">Our
            Products</h2>
        <hr class="mx-auto mt-3 mb-5" style="width:60px; border:1px solid #2c2c54;">

        <div class="container">
            <div class="d-flex justify-content-center flex-wrap gap-3">

                @foreach ($categories as $category)
                    <a href="{{ route('categories.products', $category->id) }}"
                        class="btn rounded-pill px-4 py-2
                        {{ request()->routeIs('categories.products') && request()->route('id') == $category->id
                            ? 'btn-success text-white'
                            : 'btn-outline-success' }}">
                        {{ strtoupper($category->name) }}
                    </a>
                @endforeach

            </div>
        </div>

        <div class="container mt-5">
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-md-3 col-sm-6">

                        <a href="{{ route('products.detail', $product->id) }}" class="text-decoration-none text-dark">

                            <div class="card border-0 shadow-0 h-100">

                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">

                                    @if (!empty($product->discount))
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                            {{ $product->discount }}
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body text-center">
                                    <div class="mb-2 text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>

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
                        </a>

                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 border-top" style="background-color: #fff;">
        <div class="container-fluid px-lg-5 px-md-4 px-3">
            <h3 class="fw-light text-center mb-3" style="font-family:'Playfair Display', serif; color:#2c2c54;">
                What Our Customers Say
            </h3>

            <hr class="mx-auto mb-5" style="width:80px; border-top:2px solid #2c2c54;">

            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">

                <div class="carousel-inner text-center">

                    <div class="carousel-item active">
                        <div class="d-flex flex-column align-items-center px-lg-5 px-3">
                            <i class="fas fa-quote-left fa-2x text-success mb-3"></i>
                            <p class="fst-italic text-muted" style="max-width:700px;">
                                "Code, template and others are very good..."
                            </p>
                            <div class="mt-4">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(10).jpg"
                                    class="rounded-circle shadow-sm mb-2" width="80" height="80" alt="Customer">
                                <h6 class="fw-bold mb-0 text-dark">REBECKA FILSON</h6>
                                <small class="text-muted">CEO of CSC</small>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="d-flex flex-column align-items-center px-lg-5 px-3">
                            <i class="fas fa-quote-left fa-2x text-success mb-3"></i>
                            <p class="fst-italic text-muted" style="max-width:700px;">
                                "Amazing service! The design quality exceeded expectations!"
                            </p>
                            <div class="mt-4">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(3).jpg"
                                    class="rounded-circle shadow-sm mb-2" width="80" height="80" alt="Customer">
                                <h6 class="fw-bold mb-0 text-dark">JESSICA WATSON</h6>
                                <small class="text-muted">Marketing Manager</small>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="d-flex flex-column align-items-center px-lg-5 px-3">
                            <i class="fas fa-quote-left fa-2x text-success mb-3"></i>
                            <p class="fst-italic text-muted" style="max-width:700px;">
                                "I'm very satisfied with the support team..."
                            </p>
                            <div class="mt-4">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(20).jpg"
                                    class="rounded-circle shadow-sm mb-2" width="80" height="80" alt="Customer">
                                <h6 class="fw-bold mb-0 text-dark">MICHAEL LEE</h6>
                                <small class="text-muted">UI/UX Designer</small>
                            </div>
                        </div>
                    </div>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"  style="color: black" aria-hidden="true"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"  style="color: black" aria-hidden="true"></span>
                </button>

            </div>
        </div>
    </section>

    <section class="text-center py-5 border-top" style="background-color:#fff;">
        <div class="container px-lg-5 px-md-4 px-3">
            <h4 class="fw-light mb-3" style="color:#2c2c54;">
                Get <span class="text-success fw-bold">20% Off</span> Your Next Order
            </h4>

            <div class="mx-auto" style="max-width:500px;">
                <form id="subscribeForm" onsubmit="submitForm(event)">
                    <div class="input-group border-bottom justify-content-center">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="fas fa-envelope text-muted"></i>
                        </span>

                        <input type="email" class="form-control border-0 bg-transparent shadow-0 text-center"
                            placeholder="Enter your email" required />

                        <span class="input-group-text bg-transparent border-0 text-success fw-bold"
                            style="cursor:pointer;" onclick="document.getElementById('subscribeForm').requestSubmit()">
                            Subscribe
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        function submitForm(e) {
            e.preventDefault();
            const email = e.target.querySelector('input[type="email"]').value;
            alert('Thanks for subscribing, ' + email + '!');
            e.target.reset();
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.js"></script>
@endsection
