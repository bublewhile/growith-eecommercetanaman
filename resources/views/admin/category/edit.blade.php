@extends('templates.app')

@section('content')
<style>
    body {
        background-color: #f4f7f2 !important;
        font-family: 'Lora', serif;
    }

    h5, label {
        font-family: 'Playfair Display', serif;
        color: #2e4d3d;
    }

    .card-elegant {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .card-elegant:hover {
        transform: translateY(-3px);
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

    .btn-success {
        background-color: #6db87f;
        border-radius: 50px;
        font-weight: 600;
        padding: 10px 25px;
        border: none;
    }

    .btn-success:hover {
        background-color: #5ca26f;
    }
</style>

<div class="w-75 d-block mx-auto my-5">
    <form method="POST" action="{{ route('admin.category.update', $category->id) }}" class="card card-elegant p-4">
        @csrf
        @method('PUT')

        <h5 class="text-center mb-4">Edit Data Kategori</h5>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
    </form>
</div>
@endsection
