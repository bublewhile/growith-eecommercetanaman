@extends('templates.app')

@section('content')
<style>
    body {
        font-family: 'Lora', serif;
    }

    .growith-wrapper {
        background: #f4f7f2;
        padding: 35px;
        border-radius: 20px;
        max-width: 650px;
        margin: 40px auto;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        animation: fadeIn 0.4s ease;
    }

    h2.growith-title {
        font-size: 26px;
        font-weight: 700;
        color: #2e7d32;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-control {
        border-radius: 10px !important;
        padding: 12px !important;
    }

    .btn-growith {
        background: #2e7d32;
        color: #fff;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.2s ease-in-out;
    }

    .btn-growith:hover {
        background: #256628;
        transform: scale(1.05);
    }

    .btn-cancel {
        background: #ccc;
        color: #222;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.2s ease-in-out;
    }

    .btn-cancel:hover {
        background: #b4b4b4;
        transform: scale(1.05);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="growith-wrapper">
    <h2 class="growith-title">Update Status Order</h2>

    <form method="POST" action="{{ route('staff.response.update', $order->id) }}">
        @csrf
        @method('PUT')

        {{-- STATUS ORDER --}}
        <div class="mb-3">
            <label for="status" class="form-label fw-bold text-success">Status Order</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                <option value="pending"   {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid"      {{ $order->status == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                <option value="shipped"   {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            @error('status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- CATATAN ADMIN --}}
        <div class="mb-3">
            <label for="note" class="form-label fw-bold text-success">Catatan Admin</label>
            <textarea name="note" id="note" rows="3"
                class="form-control @error('note') is-invalid @enderror"
                placeholder="Tambahkan catatan...">{{ old('note', $order->note) }}</textarea>

            @error('note')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- BUTTON --}}
        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn-growith">
                <i class="fa fa-save"></i> Simpan
            </button>

            <a href="{{ route('staff.orders.index') }}" class="btn-cancel">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
