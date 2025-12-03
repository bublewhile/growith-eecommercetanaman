@extends('templates.app')

@section('content')
<style>
    body {
        background-color: #f4f7f2 !important;
        font-family: 'Lora', serif;
    }

    label, h5 {
        font-family: 'Playfair Display', serif;
        color: #2e4d3d;
    }

    .form-control, .form-select {
        border-radius: 50px;
        padding: 10px 20px;
        border: 1px solid #dce5df;
    }

    .form-control:focus, .form-select:focus {
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
</style>

<div class="w-75 d-block mx-auto my-5">
    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h5 class="text-center mb-4">Tambah Produk Baru</h5>

        <div class="row mb-3">
            <div class="col-6">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-6">
            <label for="category" class="form-label">Kategori</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
    <option disabled selected>Pilih Kategori</option>
    @foreach ($category as $cat)
        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
        </option>
    @endforeach
</select>
@error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="price" class="form-label">Harga</label>
                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror">
                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-6">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror">
                @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="brand" class="form-label">Merek</label>
                <input type="text" name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror">
                @error('brand') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-6">
                <label for="image" class="form-label">Gambar Produk</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror"></textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">Simpan Produk</button>
    </form>
</div>
@endsection
