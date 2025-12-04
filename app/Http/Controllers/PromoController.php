<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PromoExport;
use Yajra\DataTables\Facades\DataTables;

class PromoController extends Controller
{
    public function index()
    {
        return view('staff.promo.index');
    }

    public function create()
    {
        return view('staff.promo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|unique:promos,promo_code',
            'type'       => 'required|in:percent,rupiah',
            'discount'   => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->type === 'percent' && $request->discount > 100) {
            return back()->withInput()->with('error', 'Diskon persen tidak boleh lebih dari 100');
        }

        if ($request->type === 'rupiah' && $request->discount < 1000) {
            return back()->withInput()->with('error', 'Diskon rupiah tidak boleh kurang dari 1000');
        }

        Promo::create([
            'promo_code' => $request->promo_code,
            'type'       => $request->type,
            'discount'   => $request->discount,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'activated'  => true
        ]);

        return redirect()->route('staff.promos.index')->with('success', 'Berhasil tambah data promo!');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('staff.promo.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'promo_code' => 'required',
            'type'       => 'required|in:percent,rupiah',
            'discount'   => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->type === 'percent' && $request->discount > 100) {
            return back()->withInput()->with('error', 'Diskon persen tidak boleh lebih dari 100');
        }

        if ($request->type === 'rupiah' && $request->discount < 1000) {
            return back()->withInput()->with('error', 'Diskon rupiah tidak boleh kurang dari 1000');
        }

        Promo::where('id', $id)->update([
            'promo_code' => $request->promo_code,
            'type'       => $request->type,
            'discount'   => $request->discount,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'activated'  => true
        ]);

        return redirect()->route('staff.promos.index')->with('success', 'Berhasil mengubah data promo!');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('staff.promos.index')->with('success', 'Berhasil menghapus data promo!');
    }

    public function trash()
    {
        $promos = Promo::onlyTrashed()->get();
        return view('staff.promo.trash', compact('promos'));
    }

    public function restore($id)
    {
        $promo = Promo::onlyTrashed()->findOrFail($id);
        $promo->restore();

        return redirect()->route('staff.promos.index')->with('success', 'Berhasil mengembalikan data promo!');
    }

    public function deletePermanent($id)
    {
        $promo = Promo::onlyTrashed()->findOrFail($id);
        $promo->forceDelete();

        return redirect()->route('staff.promos.index')->with('success', 'Berhasil menghapus data promo selamanya!');
    }

    public function exportExcel()
    {
        return Excel::download(new PromoExport, 'data-promo.xlsx');
    }

    public function dataForDataTables()
{
    $promos = Promo::query();

    return DataTables::of($promos)
        ->addIndexColumn()
        ->addColumn('discountPromo', fn($data) => $data->formatted_discount)
        ->addColumn('periode', fn($data) =>
            ($data->start_date ? $data->start_date->format('d M Y') : '-') .
            ($data->end_date ? $data->end_date->format('d M Y') : '-')
        )
        ->addColumn('status', function ($data) {
            if (!$data->start_date && !$data->end_date) {
                return 'Tidak ada periode';
            }
            if ($data->start_date && now()->lt($data->start_date)) {
                return 'Belum aktif';
            }
            if ($data->end_date && now()->gt($data->end_date)) {
                return 'Kadaluarsa';
            }
            return 'Valid';
        })
        ->addColumn('buttons', function ($data) {
            $btnEdit = '<a href="' . route('staff.promos.edit', $data->id) . '" class="btn btn-success me-2">Edit</a>';
            $btnDelete = '<form class="d-inline" action="' . route('staff.promos.delete', $data->id) . '" method="post">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger me-2">Hapus</button></form>';
            return '<div class="d-flex justify-content-center">' . $btnEdit . $btnDelete . '</div>';
        })
        ->rawColumns(['discountPromo', 'periode', 'status', 'buttons'])
        ->make(true);
}
}
