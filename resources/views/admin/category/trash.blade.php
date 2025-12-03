@extends('templates.app')

@section('content')
<style>
    body {
        background-color: #f4f7f2 !important;
        font-family: 'Lora', serif;
    }

    h3, th, td {
        font-family: 'Playfair Display', serif;
        color: #2e4d3d;
    }

    .btn-success {
        background-color: #6db87f;
        border-radius: 50px;
        font-weight: 600;
        padding: 6px 20px;
        border: none;
    }

    .btn-success:hover {
        background-color: #5ca26f;
    }

    .btn-danger {
        border-radius: 50px;
        padding: 6px 20px;
        font-weight: 600;
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <h3 class="mb-3">DATA SAMPAH : Kategori Produk</h3>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category as $key => $category)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <form action="{{ route('admin.category.restore', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                </form>

                                <form action="{{ route('admin.category.delete_permanent', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus Selamanya</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
