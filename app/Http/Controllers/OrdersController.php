<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Product;
use App\Models\Promo;
use App\Models\OrderPayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdersController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['category'])->findOrFail($id);
        return view('orders.detail-product', compact('product'));
    }

    public function toggleLike($id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($id);

        if ($user->likes()->where('product_id', $id)->exists()) {
            $user->likes()->detach($id);
        } else {
            $user->likes()->attach($id);
        }

        return redirect()->route('orders.liked');
    }

    public function liked()
    {
        $user = auth()->user();
        $products = $user->likes()->with('category')->get();
        return view('orders.liked', compact('products'));
    }

    // Ringkasan Order
    public function orderSummary($orderId)
    {
        $user = auth()->user();

        // kalau alamat kosong, arahkan ke form alamat
        if (empty($user->alamat)) {
            return view('orders.form-alamat', compact('user','orderId'));
        }

        // kalau alamat sudah ada, tampilkan ringkasan order
        $order = Orders::where('id', $orderId)->with('product')->first();
        $today = Carbon::today();

        $promos = Promo::where('activated', 1)
               ->whereDate('start_date', '<=', $today)
               ->whereDate('end_date', '>=', $today)
               ->get();

        return view('orders.summary', compact('order', 'promos'));
    }

    // Buat Invoice & QR
    public function createInvoice(Request $request, $orderId)
{
    $request->validate([
        'payment_method' => 'required|in:stripe,cod,bank_bri'
    ]);

    $order = Orders::find($orderId);
    if (!$order) {
        return response()->json([
            'message' => 'Order tidak ditemukan'
        ], 404);
    }

    $invoiceCode = 'ORDER' . $orderId . rand(100, 999);
    $qrImage = QrCode::format('svg')->size(300)->margin(2)->generate($invoiceCode);

    $fileName = $invoiceCode . '.svg';
    $path = 'invoices/' . $fileName;
    Storage::disk('public')->put($path, $qrImage);

    // Create Payment
    $createData = OrderPayment::create([
        'order_id' => $orderId,
        'barcode' => $path,
        'status' => 'process',
        'booked_date' => now()
    ]);

    // Simpan metode pembayaran
    $order->payment_method = $request->payment_method;
    $order->save();

    // Hitung Promo
    if ($request->promo_id != null) {
        $promo = Promo::find($request->promo_id);

        if ($promo) {
            $discount = $promo->type == 'percent'
                ? $order->total_price * $promo->discount / 100
                : $promo->discount;

            $order->update([
                'promo_id' => $promo->id,
                'total_price' => $order->total_price - $discount
            ]);
        }
    }

    return response()->json([
        'message' => 'Berhasil membuat invoice pembayaran',
        'data' => $createData
    ]);
}

    public function paymentPage($orderId)
    {
        $order = Orders::where('id', $orderId)
            ->with(['promo', 'orderPayment'])
            ->first();

        return view('orders.payment', compact('order'));
    }

    public function proofPayment($orderId)
    {
        $orderPayment = OrderPayment::where('order_id', $orderId)->firstOrFail();
        $orderPayment->update(['status' => 'paid', 'paid_date' => now()]);

        return redirect()->route('orders.receipt', $orderId);
    }


    public function receipt($orderId)
    {
        $order = Orders::where('id', $orderId)->with(['product', 'orderPayment'])->first();
        return view('orders.receipt', compact('order'));
    }

    public function exportPdf($orderId)
    {
        $order = Orders::where('id', $orderId)->with(['product', 'orderPayment', 'promo'])->firstOrFail();

        $pdf = Pdf::loadView('orders.pdf', compact('order'));

        $fileName = 'ORDER' . $order->id . '.pdf';
        return $pdf->download($fileName);
    }


    public function createOrder(Request $request, $productId)
    {
    $request->validate([
        'size' => 'required|string',
        'pot_material' => 'required|string',
        'pot_color' => 'required|string',
    ]);

    $product = Product::findOrFail($productId);

    $order = Orders::create([
        'user_id'     => auth()->id(),
        'product_id'  => $productId,
        'quantity'    => 1,
        'size'         => $request->size,
        'pot_material' => $request->pot_material,
        'pot_color'    => $request->pot_color,
        'total_price' => $product->price,
        'shipping_fee'=> 10000,
        'status'      => 'process',
    ]);
    return redirect()->route('orders.summary', $order->id);
    }

    public function chartData()
    {
        // ambil bulan sekarang
        $month = now()->format('m');

        // ambil semua order yang sudah dibayar di bulan ini
        $orders = Orders::whereHas('orderPayment', function($q) use ($month) {
            $q->whereMonth('booked_date', $month)
            ->whereNotNull('paid_date'); // hanya yang sudah dibayar
        })->get()->groupBy(function ($order) {
            // group berdasarkan tanggal booked_date
            return \Carbon\Carbon::parse($order['orderPayment']['booked_date'])->format('Y-m-d');
        })->toArray();

        // ambil tanggal sebagai label chart
        $labels = array_keys($orders);

        // ambil jumlah order per tanggal
        $data = [];
        foreach ($orders as $orderGroup) {
            array_push($data, count($orderGroup));
        }

        // return JSON untuk Chart.js
        return response()->json([
            'labels' => $labels,
            'data'   => $data
        ]);
    }

    public function storeAlamat(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'required|string|max:255',
            'kota'         => 'required|string|max:255',
            'provinsi'     => 'required|string|max:255',
            'kode_pos'     => 'required|string|max:20',
            'no_hp'        => 'required|string|max:20',
        ]);

        $user = $request->user();
        $user->update($request->only([
            'nama_lengkap','alamat','kota','provinsi','kode_pos','no_hp'
        ]));

        // pakai order_id dari form
        return redirect()->route('orders.summary', $request->order_id)
            ->with('success_message', 'Alamat berhasil disimpan, lanjut ke ringkasan order.');
    }

    public function dataPetugas()
    {
        $orders = Orders::with(['product', 'orderPayment', 'promo', 'user'])
            ->latest()
            ->get();

        return view('staff.manage-product.data', compact('orders'));
    }

    public function dataStatus()
    {
        $orders = Orders::with(['product', 'orderPayment', 'promo', 'user'])
            ->latest()
            ->get();

        return view('staff.manage-product.data', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        $request->validate([
            'response' => 'required|string|max:500'
        ]);

        $orders->update([
            'response' => $request->response,
            'status'   => 'responded' // opsional
        ]);

        return redirect()->route('staff.manage')
                        ->with('success_message', 'Response berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
