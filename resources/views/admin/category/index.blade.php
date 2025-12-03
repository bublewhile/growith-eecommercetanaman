@extends('templates.app')

@section('content')
<style>
    body {
        background-color: #f4f7f2 !important;
        font-family: 'Lora', serif;
    }

    h5, th, td {
        font-family: 'Playfair Display', serif;
        color: #2e4d3d;
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

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: end;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-4">
    <div class="action-buttons">
        <a href="{{ route('admin.category.export') }}" class="btn btn-secondary">Export (.xlsx)</a>
        <a href="{{ route('admin.category.trash') }}" class="btn btn-secondary">Data Sampah</a>
        <a href="{{ route('admin.category.create') }}" class="btn btn-success">Tambah Data</a>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <h5 class="mb-3">Data Kategori Produk</h5>

    <div class="table-responsive">
        <table class="table table-bordered" id="kategoriTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function() {
        $('#kategoriTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.category.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name', orderable: true, searchable: true },
                { data: 'buttons', name: 'buttons', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
