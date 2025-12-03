@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.product.export') }}" class="btn btn-secondary me-2">Export (.xlsx)</a>
        <a href="{{ route('admin.product.trash') }}" class="btn btn-secondary me-2">Data Sampah</a>
        <a href="{{ route('admin.product.create') }}" class="btn btn-success">Tambah Produk</a>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success mt-3">{{ Session::get('success') }}</div>
    @endif

    <h5 class="mt-3">Data Produk</h5>
    <table class="table table-bordered" id="productTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalDetailBody">...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function() {
        $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.product.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'imgPreview', name: 'imgPreview', orderable: false, searchable: false },
                { data: 'name', name: 'name', orderable: true, searchable: true },
                { data: 'activeBadge', name: 'activeBadge', orderable: true, searchable: true },
                { data: 'buttons', name: 'buttons', orderable: false, searchable: false }
            ]
        });
    });

    function showModal(item) {
        let image = "{{ asset('storage/') }}" + "/" + item.image;
        let content = `
            <img src="${image}" width="120" class="d-block mx-auto my-2">
            <ul>
                <li>Nama Produk : ${item.name}</li>
                <li>Kategori : ${item.category?.name ?? '-'}</li>
                <li>Harga : Rp${item.price}</li>
                <li>Stok : ${item.stock}</li>
                <li>Merek : ${item.brand}</li>
                <li>Deskripsi : ${item.description}</li>
            </ul>
        `;

        document.querySelector("#modalDetailBody").innerHTML = content;
        new bootstrap.Modal(document.querySelector("#modalDetail")).show();
    }
</script>
@endpush
