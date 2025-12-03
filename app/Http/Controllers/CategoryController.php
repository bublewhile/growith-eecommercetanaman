<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryExport;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function homeCategory()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return view('categories.index', compact('categories'));
    }

    public function showProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)
            ->where('actived', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('categories.products', compact('category', 'products'));
    }

    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ], [
            'name.required' => 'Category name is required.'
        ]);

        $createData = Category::create([
            'name' => $request->name
        ]);

        if ($createData) {
            return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil ditambahkan!');
        } else {
            return back()->with('error', 'Gagal menambahkan kategori. Coba lagi.');
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ], [
            'name.required' => 'Category name is required.'
        ]);

        $updateData = Category::where('id', $id)->update([
            'name' => $request->name
        ]);

        if ($updateData) {
            return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui!');
        } else {
            return back()->with('error', 'Gagal memperbaharui kategori. Coba lagi.');
        }
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus!');
    }

    public function trash()
    {
        $category = Category::onlyTrashed()->get();
        return view('admin.category.trash', compact('category'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dikembalikan!');
    }

    public function deletePermanent($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus permanen!');
    }

    public function exportExcel()
    {
        return Excel::download(new CategoryExport, 'category-data.xlsx');
    }

    public function dataForDataTables()
    {
        $category = Category::query();

        return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('buttons', function ($data) {
                $btnEdit = '<a href="' . route('admin.category.edit', $data->id) . '" class="btn btn-success me-2">Edit</a>';
                $btnDelete = '<form class="d-inline" action="' . route('admin.category.delete', $data->id) . '" method="post">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger me-2">Delete</button></form>';
                return '<div class="d-flex justify-content-center">' . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['buttons'])
            ->make(true);
    }
}
