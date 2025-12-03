@extends('templates.app')
@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        @if (Session::get('success'))
            <div class="alert alert-success mt-3">{{ Session::get('success') }}</div>
        @endif

        <h3 class="my-3">DATA SAMPAH : Produk</h3>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" width="120">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->actived == 1)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-warning">Non-aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <form action="{{ route('admin.product.restore', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                    </form>

                                    <form action="{{ route('admin.product.delete_permanent', $product->id) }}" method="POST">
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
