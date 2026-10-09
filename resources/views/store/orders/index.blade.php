@extends('layouts.app')

@section('title', 'Orders')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">Orders</h1>
      <p class="page-subtitle">Confirm orders and mark them paid once cash is received.</p>
    </div>
    <a href="{{ route('store.orders.export') }}" class="btn-custom btn-custom-light">
      <i class="bi bi-file-earmark-arrow-down"></i> Export CSV
    </a>
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
            <th>Order</th><th>Buyer</th><th>Produce</th><th>Total</th><th>Fulfillment</th><th>Status</th><th>Payment</th><th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $o)
            <tr>
              <td class="table-order-id">{{ $o->reference }}<div class="table-user-sub">{{ $o->created_at->format('M d, Y') }}</div></td>
              <td>{{ $o->buyer->name }}<div class="table-user-sub">{{ $o->buyer->phone }}</div></td>
              <td>{{ $o->produce->name }} &times; {{ $o->quantity }} {{ $o->produce->unit }}</td>
              <td class="table-amount">₱{{ number_format($o->total, 2) }}</td>
              <td>{{ ucfirst($o->fulfillment) }}</td>
              <td><span class="badge-table {{ $o->statusBadge() }}">{{ ucfirst($o->status) }}</span></td>
              <td><span class="badge-table {{ $o->paymentBadge() }}">{{ ucfirst($o->payment_status) }}</span></td>
              <td class="text-end">
                <div class="d-inline-flex flex-wrap gap-1 justify-content-end">
                  @php
                    $actions = [];
                    if ($o->status === 'pending') $actions['confirm'] = ['Confirm', 'btn-custom-primary'];
                    if ($o->status === 'confirmed') $actions['complete'] = ['Complete', 'btn-custom-primary'];
                    if ($o->status !== 'cancelled' && $o->payment_status === 'unpaid') $actions['paid'] = ['Mark Paid', 'btn-custom-secondary'];
                    if ($o->isOpen()) $actions['cancel'] = ['Cancel', 'btn-custom-danger'];
                  @endphp
                  @foreach ($actions as $action => [$label, $class])
                    <form method="POST" action="{{ route('store.orders.update', $o) }}"
                          @if ($action === 'cancel') onsubmit="return confirm('Cancel order {{ $o->reference }}?')" @endif>
                      @csrf @method('PATCH')
                      <input type="hidden" name="action" value="{{ $action }}">
                      <button type="submit" class="btn-custom btn-custom-sm {{ $class }}">{{ $label }}</button>
                    </form>
                  @endforeach
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-center py-4">No orders yet.</td></tr>
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
