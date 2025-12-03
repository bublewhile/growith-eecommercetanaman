@extends('templates.app')

@section('content')
<style>
    body {
        background-color: #f4f7f2 !important;
        font-family: 'Lora', serif;
    }

    .card-elegant {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .card-elegant:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border-radius: 50px;
        padding: 10px 20px;
        border: 1px solid #dce5df;
    }

    .form-control:focus {
        border-color: #6db87f;
        box-shadow: 0 0 0 0.2rem rgba(109, 184, 127, 0.25);
    }

    .btn-green {
        background-color: #6db87f;
        color: white;
        border-radius: 50px;
        font-weight: 600;
        padding: 10px 25px;
        transition: 0.3s ease;
        border: none;
    }

    .btn-green:hover {
        background-color: #5ca26f;
        color: #fff;
    }

    small.text-danger {
        font-size: 0.85rem;
    }
</style>

<div class="position-relative" style="height: 85vh;">
    <div class="position-absolute top-50 start-50 translate-middle" style="width: 80%; max-width: 540px;">
        <div class="card card-elegant p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold" style="color: #3b5d50;">🌱 Tambah Data Staff</h4>
                <p class="text-muted">Isi data staff baru dengan benar</p>
            </div>

            @if (Session::get('success'))
                <div class="alert alert-success text-center py-2">{{ Session::get('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" placeholder="Masukkan nama lengkap"
                           value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" placeholder="Masukkan alamat email"
                           value="{{ old('email') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="Masukkan password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-green">
                        <strong>Buat Staff 🌿</strong>
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none" style="color: #3b5d50;">
                    ← Kembali ke daftar staff
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
