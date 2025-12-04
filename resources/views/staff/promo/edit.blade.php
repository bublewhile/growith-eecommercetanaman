@extends('templates.app')

@section('content')
    <style>
        body {
            background-color: #f4f7f2 !important;
            font-family: 'Lora', serif;
        }

        h5,
        label {
            font-family: 'Playfair Display', serif;
            color: #2e4d3d;
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

        .form-control {
            border-radius: 50px;
            padding: 10px 20px;
            border: 1px solid #dce5df;
        }

        .form-control:focus {
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
    </style>

    <div class="container w-75 d-block mx-auto my-5">
        <form method="POST" action="{{ route('staff.promos.update', $promo->id) }}" class="card card-elegant p-4">
            @csrf
            @method('PUT')

            @if (Session::get('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <h5 class="text-center mb-4">Edit Data Promo</h5>

            <div class="mb-3">
                <label for="promo_code" class="form-label">Kode Promo</label>
                <input type="text" class="form-control @error('promo_code') is-invalid @enderror" id="promo_code"
                    name="promo_code" value="{{ old('promo_code', $promo->promo_code) }}">
                @error('promo_code')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipe Promo</label>
                <select name="type" class="form-control @error('type') is-invalid @enderror" id="type">
                    <option value="percent" {{ $promo->type == 'percent' ? 'selected' : '' }}>%</option>
                    <option value="rupiah" {{ $promo->type == 'rupiah' ? 'selected' : '' }}>Rupiah</option>
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="discount" class="form-label">Jumlah Potongan</label>
                <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount"
                    name="discount" value="{{ old('discount', $promo->discount) }}">
                <small class="form-text text-muted">Isi sesuai tipe yang dipilih (% atau Rupiah)</small>
                @error('discount')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai Promo</label>
                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                    name="start_date" value="{{ old('start_date', $promo->start_date?->format('Y-m-d')) }}">
                @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Berakhir Promo</label>
                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                    name="end_date" value="{{ old('end_date', $promo->end_date?->format('Y-m-d')) }}">
                @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success w-100">Kirim</button>
        </form>
    </div>
@endsection
