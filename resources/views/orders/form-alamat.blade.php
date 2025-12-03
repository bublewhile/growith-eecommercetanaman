@extends('templates.app')

@section('content')
<style>
    /* ===== GROWITH GREEN AESTHETIC FORM ===== */
    .growith-wrapper {
        background: #f4f7f2;
        padding: 40px;
        border-radius: 22px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        animation: fadeIn 0.3s ease;
    }

    h1.growith-title {
        font-size: 28px;
        font-weight: 700;
        color: #2e7d32;
        margin-bottom: 25px;
    }

    .growith-label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #355f3e;
    }

    .growith-input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #cfd8d0;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .growith-input:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 3px rgba(46,125,50,0.2);
        outline: none;
    }

    .growith-btn {
        padding: 14px;
        border-radius: 14px;
        border: none;
        width: 100%;
        background: #2e7d32;
        color: white;
        font-size: 16px;
        font-weight: 600;
        margin-top: 12px;
        transition: background 0.2s ease;
    }

    .growith-btn:hover {
        background: #256628;
    }

    /* animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container my-5 growith-wrapper">
    <h1 class="growith-title">Isi Alamat Pengiriman</h1>

    @if ($errors->any())
        <div class="alert alert-danger mb-4 rounded-3">
            <ul class="m-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.alamat.store') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $orderId }}">

        <div class="mb-3">
            <label class="growith-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="growith-input"
                value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
        </div>

        <div class="mb-3">
            <label class="growith-label">Alamat</label>
            <input type="text" name="alamat" class="growith-input"
                value="{{ old('alamat') }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="growith-label">Kota</label>
                <input type="text" name="kota" class="growith-input"
                    value="{{ old('kota') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="growith-label">Provinsi</label>
                <input type="text" name="provinsi" class="growith-input"
                    value="{{ old('provinsi') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="growith-label">Kode Pos</label>
                <input type="text" name="kode_pos" class="growith-input"
                    value="{{ old('kode_pos') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="growith-label">No. HP</label>
                <input type="text" name="no_hp" class="growith-input"
                    value="{{ old('no_hp') }}" required>
            </div>
        </div>

        <button type="submit" class="growith-btn">
            SIMPAN ALAMAT & LANJUTKAN
        </button>
    </form>
</div>
@endsection
