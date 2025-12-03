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

</style>

<div class="container my-5">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('staff.promos.export') }}" class="btn btn-secondary me-2">Export (.xlsx)</a>
        <a href="{{ route('staff.promos.trash') }}" class="btn btn-secondary me-2">Data Sampah</a>
        <a href="{{ route('staff.promos.create') }}" class="btn btn-success">Tambah Data</a>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <h5 class="mb-3">Data Promo</h5>

    <div class="table-responsive">
        <table class="table table-bordered" id="promoTable">
            <thead class="table-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>Kode Promo</th>
                    <th>Total Potongan</th>
                    <th>Tanggal Berlaku</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal Detail (opsional) -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Detail Promo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
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
        $('#promoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('staff.promos.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'promo_code', name: 'promo_code', orderable: true, searchable: true, className: 'text-center'},
                { data: 'discountPromo', name: 'discount', className: 'text-center' },
                { data: 'valid_until', name: 'valid_until', className: 'text-center' },
                { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center'},
                { data: 'buttons', name: 'buttons', orderable: false, searchable: false, className: 'text-center'}
            ]
        });
    });

    function showModal(promo) {
    let content = `
        <ul class="list-unstyled">
            <li><strong>Kode Promo:</strong> ${promo.promo_code}</li>
            <li><strong>Tipe:</strong> ${promo.type}</li>
            <li><strong>Jumlah Potongan:</strong> ${promo.discount}</li>
            <li><strong>Tanggal Berlaku:</strong> ${promo.valid_until ?? '-'}</li>
            <li><strong>Status:</strong> ${promo.status}</li>
        </ul>
    `;
    document.querySelector("#modalDetailBody").innerHTML = content;
    new bootstrap.Modal(document.querySelector("#modalDetail")).show();
}
</script>
@endpush
