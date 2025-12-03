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

    .breadcrumb {
        background-color: #e8f3ec !important;
        border-radius: 50px;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: #6db87f;
    }

    .breadcrumb-item.active {
        color: #4b735e;
        font-weight: 600;
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

    h5.title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        color: #2e4d3d;
    }

    small.text-danger {
        font-size: 0.85rem;
    }
</style>

<div class="position-relative" style="height: 85vh;">
    <div class="position-absolute top-50 start-50 translate-middle" style="width: 80%; max-width: 540px;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb shadow-sm p-3 mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-success text-decoration-none">Pengguna</a></li>
                <li class="breadcrumb-item">Data</li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <!-- Card -->
        <form method="POST" action="{{ route('admin.users.update', $users->id) }}" class="card card-elegant p-4">
            @csrf
            @method('PUT')

            <h5 class="title text-center mb-4">Ubah Data Staff</h5>

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" value="{{ $users['name'] }}">
                @error('name')
                    <small class="text-danger d-block mt-1">*{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ $users['email'] }}">
                @error('email')
                    <small class="text-danger d-block mt-1">*{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="text" class="form-control @error('password') is-invalid @enderror"
                    id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                @error('password')
                    <small class="text-danger d-block mt-1">*{{ $message }}</small>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-green">
                    <i class="fas fa-save me-2"></i> Ubah Data
                </button>
            </div>
        </form>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection
