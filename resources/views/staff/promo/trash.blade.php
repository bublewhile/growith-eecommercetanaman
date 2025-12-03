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

    .table-responsive {
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background-color: #fff;
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('staff.promos.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <h3 class="mb-3">DATA SAMPAH : Promo</h3>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode Promo</th>
                    <th>Total Potongan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promos as $key => $promo)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $promo->promo_code }}</td>
                        <td>
                            @if ($promo->type == 'percent')
                                {{ $promo->discount }}%
                            @else
                                Rp {{ number_format($promo->discount, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <form action="{{ route('staff.promos.restore', $promo->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                </form>

                                <form action="{{ route('staff.promos.delete_permanent', $promo->id) }}" method="POST">
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
