@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">My Orders</h1>
      <p class="page-subtitle">Track your purchases. Payment is made in cash when you receive the produce.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('buyer.orders.export') }}" class="btn-custom btn-custom-light"><i class="bi bi-file-earmark-arrow-down"></i> Export CSV</a>
      <a href="{{ route('buyer.browse') }}" class="btn-custom btn-custom-primary"><i class="bi bi-cart-plus"></i> New Order</a>
    </div>
  </div>

  <div class="table-card-custom">
    <div class="table-header-control">
      <form method="GET" class="table-filter-group">
        <select name="status" class="form-select-custom" onchange="this.form.submit()">
          <option value="">All statuses</option>
          @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </form>
    </div>

    <div class="table-responsive">
      <table class="table-custom">
        <thead>
          <tr>
            <th>Order</th><th>Store</th><th>Produce</th><th>Total</th><th>Fulfillment</th><th>Notes</th><th>Status</th><th>Payment</th><th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $o)
            <tr>
              <td class="table-order-id">{{ $o->reference }}<div class="table-user-sub">{{ $o->created_at->format('M d, Y') }}</div></td>
              <td>{{ $o->store->displayName() }}</td>
              <td>{{ $o->produce->name }} &times; {{ $o->quantity }} {{ $o->produce->unit }}</td>
              <td class="table-amount">₱{{ number_format($o->total, 2) }}</td>
              <td>{{ ucfirst($o->fulfillment) }}</td>
              <td>{{ $o->notes ?: '—' }}</td>
              <td><span class="badge-table {{ $o->statusBadge() }}">{{ ucfirst($o->status) }}</span></td>
              <td><span class="badge-table {{ $o->paymentBadge() }}">{{ ucfirst($o->payment_status) }}</span></td>
              <td class="text-end">
                @if ($o->status === 'pending')
                  <form method="POST" action="{{ route('buyer.orders.cancel', $o) }}"
                        onsubmit="return confirm('Cancel order {{ $o->reference }}?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-custom btn-custom-sm btn-custom-danger">Cancel</button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="text-center py-4">No orders yet. <a href="{{ route('buyer.browse') }}">Browse produce</a> to place your first order.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($orders->hasPages())
      <div class="table-footer-control">
        <div class="table-pagination-info">Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }}</div>
        {{ $orders->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
@endsection