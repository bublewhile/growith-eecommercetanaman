@extends('templates.app')

@section('content')
<style>
    body {
        background-color: #f4f7f2 !important;
        font-family: 'Lora', serif;
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

    h5 {
        font-family: 'Playfair Display', serif;
        color: #2e4d3d;
    }
</style>

<div class="container mt-3">
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.users.export') }}" class="btn btn-secondary me-2">Export (.xlsx)</a>
        <a href="{{ route('admin.users.trash') }}" class="btn btn-secondary me-2">Data Sampah</a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Data</a>
    </div>

    <h5 class="mt-3">Data Pengguna (Staff & Admin)</h5>

    <div class="table-responsive">
        <table class="table table-bordered" id="userTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Detail Pengguna</h5>
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
        $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.users.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name', orderable: true, searchable: true },
                { data: 'email', name: 'email', orderable: true, searchable: true },
                { data: 'roleBadge', name: 'role', orderable: false, searchable: false },
                { data: 'buttons', name: 'buttons', orderable: false, searchable: false }
            ]
        });
    });

    function showModal(user) {
        let content = `
            <ul>
                <li>Nama Lengkap : ${user.name}</li>
                <li>Email : ${user.email}</li>
                <li>Role : ${user.role}</li>
            </ul>
        `;
        document.querySelector("#modalDetailBody").innerHTML = content;
        new bootstrap.Modal(document.querySelector("#modalDetail")).show();
    }
</script>
@endpush
