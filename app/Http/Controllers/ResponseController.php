<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Orders;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::with('order')->latest()->get();
        return view('responses.index', compact('responses'));
    }

    public function create()
    {
        return view('responses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'type'     => 'required|in:ditolak,diterima',
        ]);

        Response::create([
            'order_id' => $request->order_id,
            'type'     => $request->type,
        ]);

        return redirect()->route('staff.orders.index')
            ->with('success', 'Response berhasil ditambahkan!');
    }

    public function show(Response $response)
    {
        return view('responses.show', compact('response'));
    }

    public function edit($order_id)
    {
        $response = Response::where('order_id', $order_id)->first();
        $order = Orders::findOrFail($order_id);

        return view('staff.manage-product.response', compact('order', 'response'));
    }

    public function update(Request $request, $order_id)
    {
        $request->validate([
            'type'   => 'required|in:ditolak,diterima',
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
            'note'   => 'nullable|string|max:255',
        ]);

        // Update response
        Response::updateOrCreate(
            ['order_id' => $order_id],
            ['type'     => $request->type]
        );

        // Update order status & note
        $order = Order::findOrFail($order_id);
        $order->update([
            'status' => $request->status,
            'note'   => $request->note,
        ]);

        return redirect()->route('staff.orders.index')
            ->with('success', 'Status order berhasil diperbarui!');
    }

    public function destroy(Response $response)
    {
        $response->delete();
        return redirect()->route('staff.orders.index')
            ->with('success', 'Response berhasil dihapus!');
    }
}
