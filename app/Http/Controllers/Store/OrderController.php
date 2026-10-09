<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Concerns\ExportsOrders;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    use ExportsOrders;

    public function index(Request $request): View
    {
        $orders = $request->user()->sales()
            ->with(['buyer', 'produce'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('store.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->store_id === $request->user()->id, 403);

        $action = $request->validate(['action' => ['required', 'in:confirm,complete,paid,cancel']])['action'];

        DB::transaction(function () use ($order, $action) {
            if ($action === 'confirm' && $order->status === 'pending') {
                $order->update(['status' => 'confirmed']);
            } elseif ($action === 'complete' && $order->status === 'confirmed') {
                $order->update(['status' => 'completed']);
            } elseif ($action === 'paid' && $order->status !== 'cancelled') {
                $order->update(['payment_status' => 'paid']);
            } elseif ($action === 'cancel' && $order->isOpen()) {
                $order->update(['status' => 'cancelled']);
                $order->restock();
            }
        });

        return back()->with('success', 'Order '.$order->reference.' updated.');
    }

    public function export(Request $request)
    {
        return $this->exportOrders($request->user()->sales(), 'Buyer', 'buyer');
    }
}
