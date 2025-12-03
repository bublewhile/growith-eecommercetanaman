<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    // Halaman home: tampilkan produk terbaru
    public function home()
    {
        $products = Product::where('actived', 1)->orderBy('created_at', 'DESC')->limit(8)->get();
        $categories = Category::orderBy('created_at', 'DESC')->get();

        return view('home', compact('products', 'categories'));
    }

    // Halaman semua produk + pencarian
    public function homeAllProduct(Request $request)
    {
        $name = $request->search_product;

        if ($name != "") {
            $products = Product::where('name', 'LIKE', '%'.$name.'%')->where('actived', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            $products = Product::where('actived', 1)->orderBy('created_at', 'DESC')->get();
        }

        return view('products', compact('products'));
    }

    public function index()
    {
        return view('admin.product.index');
    }

    public function create()
    {
        $category = Category::all();
        return view('admin.product.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:category,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'description' => 'required|string|min:10'
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(5) . "-product." . $image->getClientOriginalExtension();
            $path = $image->storeAs("products", $imageName, "public");
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'brand' => $request->brand,
            'image' => $path,
            'description' => $request->description,
            'actived' => 1
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil ditambahkan!');
        }

        public function edit($id)
        {
            $product = Product::findOrFail($id);
            $category = Category::all();
            return view('admin.product.edit', compact('product', 'category'));
        }

        public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:100',
                'category_id' => 'required|exists:category,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'brand' => 'nullable|string|max:100',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
                'description' => 'required|string|min:10'
            ]);

            $product = Product::findOrFail($id);
            $path = $product->image;

            if ($request->hasFile('image')) {
                // hapus gambar lama
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                // upload gambar baru
                $image = $request->file('image');
                $imageName = Str::random(5) . "-product." . $image->getClientOriginalExtension();
                $path = $image->storeAs("products", $imageName, "public");
            }

            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'brand' => $request->brand,
                'image' => $path,
                'description' => $request->description,
                'actived' => 1
            ]);

            return redirect()->route('admin.product.index')->with('success', 'Produk berhasil diperbarui!');
        }

        public function productDetail($product_id)
        {
            $product = Product::with(['category','comments.user'])->findOrFail($product_id);
            // ambil produk terkait berdasarkan kategori yang sama
            $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();

            return view('orders.detail-product', compact('product', 'relatedProducts'));
        }

        public function destroy($id)
        {
            $product = Product::findOrFail($id);
            if ($product->image) {
                $imagePath = storage_path("app/public/" . $product->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $product->delete();
            return redirect()->route('admin.product.index')->with('success', 'Produk berhasil dihapus!');
        }

        public function toggle($id)
        {
            $product = Product::findOrFail($id);
            $product->actived = $product->actived ? 0 : 1;
            $product->save();

            return redirect()->route('admin.product.index')->with('success', 'Status produk berhasil diubah!');
        }

        public function trash()
        {
            $products = Product::onlyTrashed()->get();
            return view('admin.product.trash', compact('products'));
        }

        public function restore($id)
        {
            $product = Product::onlyTrashed()->find($id);
            $product->restore();

            return redirect()->route('admin.product.index')->with('success', 'Produk berhasil dikembalikan!');
        }

        public function deletePermanent($id)
        {
            $product = Product::onlyTrashed()->find($id);
            $product->forceDelete();

            return redirect()->route('admin.product.index')->with('success', 'Produk dihapus permanen!');
        }

        public function export()
        {
            //nama file yng akan di unduh
            $fileNama = 'data-produk.xlsx';
            //proses unduh
            return Excel::download(new ProductExport, $fileNama);
        }

        public function dataForDataTables()
        {
            $products = Product::with('category')->select('products.*');

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('imgPreview', function ($data) {
                    $urlImage = asset('storage/' . $data->image);
                    return '<img src="' . $urlImage . '" width="100">';
                })
                ->addColumn('category', function ($data) {
                    return $data->category->name ?? '';
                })
                ->addColumn('activeBadge', function ($data) {
                    return $data->actived
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>';
                })
                ->addColumn('buttons', function ($data) {
                    $btnDetail = '<button class="btn btn-secondary me-2" onclick=\'showModal('. json_encode($data) .')\'>Detail</button>';
                    $btnEdit = '<a href="' . route('admin.product.edit', $data->id) . '" class="btn btn-success me-2">Edit</a>';
                    $btnDelete = '<form class="me-2" action="' . route('admin.product.delete', $data->id) . '" method="post">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger">Hapus</button></form>';
                    $btnToggle = '<form class="me-2 toggle-status" action="' . route('admin.product.toggle', $data->id) . '" method="post">'
                        . csrf_field() . method_field('PUT') .
                        '<button type="submit" class="btn btn-' . ($data->actived ? 'warning">Nonaktif' : 'success">Aktifkan') . '</button></form>';

                    return '<div class="d-flex justify-content-center">' . $btnDetail . $btnEdit . $btnDelete . $btnToggle . '</div>';
                })
                ->rawColumns(['imgPreview', 'category', 'activeBadge', 'buttons'])
                ->make(true);
        }

        public function dataChart()
        {
            // Hitung produk aktif & nonaktif
            $productActive = Product::where('actived', 1)->count();
            $productNonActive = Product::where('actived', 0)->count();

            // Label chart
            $labels = ['Produk Aktif', 'Produk Non Aktif'];
            $data = [$productActive, $productNonActive];

            // Return JSON untuk Chart.js
            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);
        }

        public function like($id)
        {
            $product = Product::findOrFail($id);
            $user = auth()->user();

            // Cek kalau user sudah like -> jangan duplicate
            if ($product->likedBy()->where('user_id', $user->id)->exists()) {
                $product->likedBy()->detach($user->id);
                return back()->with('success', 'Berhasil un-like produk.');
            }

            // Kalau belum like -> attach
            $product->likedBy()->attach($user->id);

            return back()->with('success', 'Berhasil like produk.');
        }

}
