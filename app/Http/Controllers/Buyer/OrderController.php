<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Concerns\ExportsOrders;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Produce;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    use ExportsOrders;

    public function index(Request $request): View
    {
        $orders = $request->user()->purchases()
            ->with(['store', 'produce'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('buyer.orders', compact('orders'));
    }

    /** Place an order (Cash on Pickup/Delivery). Stock is checked and decremented atomically. */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'produce_id' => ['required', 'exists:produces,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'fulfillment' => ['required', 'in:pickup,delivery'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $order = DB::transaction(function () use ($data, $request) {
            $produce = Produce::lockForUpdate()->findOrFail($data['produce_id']);

            if ($data['quantity'] > $produce->stock) {
                return null;
            }

            $produce->decrement('stock', $data['quantity']);

            return Order::create([
                'reference' => 'ANI-'.strtoupper(Str::random(6)),
                'buyer_id' => $request->user()->id,
                'store_id' => $produce->store_id,
                'produce_id' => $produce->id,
                'quantity' => $data['quantity'],
                'total' => $produce->price * $data['quantity'],
                'fulfillment' => $data['fulfillment'],
                'notes' => $data['notes'] ?? null,
            ]);
        });

        if (! $order) {
            return back()->withInput()->withErrors(['quantity' => 'Requested quantity exceeds the available stock.']);
        }

        return redirect()->route('buyer.orders.index')
            ->with('success', 'Order '.$order->reference.' placed. Pay in cash on '.$order->fulfillment.'.');
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->buyer_id === $request->user()->id, 403);

        if ($order->status !== 'pending') {
            return back()->withErrors(['order' => 'Only pending orders can be cancelled.']);
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);
            $order->restock();
        });

        return back()->with('success', 'Order '.$order->reference.' cancelled.');
    }

    public function export(Request $request)
    {
        return $this->exportOrders($request->user()->purchases(), 'Store', 'store');
    }
}
