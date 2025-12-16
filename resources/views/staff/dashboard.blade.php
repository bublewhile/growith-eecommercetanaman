@extends('templates.app')

@section('content')
    <div class="container py-5">
        <h3 class="fw-bold text-success mb-4">Staff Dashboard 🌿</h3>

        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }} <b>{{ Auth::user()->name }}</b>!
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-seedling fa-2x text-success mb-3"></i>
                        <h5>Total Promo Aktif</h5>
                        <h3 class="fw-bold text-success">{{ $totalPromoAktif ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-users fa-2x text-success mb-3"></i>
                        <h5>Total Promo Tidak Aktif</h5>
                        <h3 class="fw-bold text-success">{{ $totalPromoTidakAktif ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
