@extends('layouts.app')

@section('title', 'Price Comparison')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">Price Comparison</h1>
      <p class="page-subtitle">See the lowest, average and highest price for each produce across stores.</p>
    </div>
  </div>

  <div class="table-card-custom">
    <div class="table-responsive">
      <table class="table-custom">
        <thead>
          <tr>
            <th>Produce</th><th>Lowest</th><th>Average</th><th>Highest</th><th>Stores</th><th>Cheapest at</th><th class="text-end"></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($prices as $row)
            <tr>
              <td class="table-product-name">{{ $row->name }}</td>
              <td class="table-amount">₱{{ number_format($row->min_price, 2) }} / {{ $row->unit }}</td>
              <td>₱{{ number_format($row->avg_price, 2) }}</td>
              <td>₱{{ number_format($row->max_price, 2) }}</td>
              <td>{{ $row->store_count }}</td>
              <td>{{ $row->cheapest?->store->displayName() }}</td>
              <td class="text-end">
                <a href="{{ route('buyer.browse', ['q' => $row->name]) }}" class="btn-custom btn-custom-sm btn-custom-primary">Order</a>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center py-4">No produce available to compare yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
