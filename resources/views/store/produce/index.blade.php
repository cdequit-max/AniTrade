@extends('layouts.app')

@section('title', 'My Produce')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">My Produce</h1>
      <p class="page-subtitle">Manage your listings, prices and stock levels.</p>
    </div>
    <a href="{{ route('store.produce.create') }}" class="btn-custom btn-custom-primary">
      <i class="bi bi-plus-lg"></i> Add Produce
    </a>
  </div>

  <div class="table-card-custom">
    <div class="table-header-control">
      <form method="GET" class="table-search-box">
        <i class="bi bi-search table-search-icon"></i>
        <input type="text" name="q" value="{{ request('q') }}" class="table-search-input" placeholder="Search produce...">
      </form>
    </div>

    <div class="table-responsive">
      <table class="table-custom">
        <thead>
          <tr>
            <th>Produce</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($produces as $p)
            <tr>
              <td class="table-product-name">{{ $p->name }}</td>
              <td>{{ $p->category }}</td>
              <td class="table-amount">₱{{ number_format($p->price, 2) }} / {{ $p->unit }}</td>
              <td>{{ number_format($p->stock) }} {{ $p->unit }}</td>
              <td>
                @if ($p->stock === 0)
                  <span class="badge-table failed">Sold out</span>
                @elseif ($p->stock <= 10)
                  <span class="badge-table pending">Low stock</span>
                @else
                  <span class="badge-table success">In stock</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('store.produce.edit', $p) }}" class="table-btn-action" title="Edit"><i class="bi bi-pencil"></i></a>
                  <form method="POST" action="{{ route('store.produce.destroy', $p) }}"
                        onsubmit="return confirm('Remove {{ e($p->name) }} from your listings?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="table-btn-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center py-4">No produce listed yet. <a href="{{ route('store.produce.create') }}">Add your first item</a>.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($produces->hasPages())
      <div class="table-footer-control">
        <div class="table-pagination-info">Showing {{ $produces->firstItem() }}–{{ $produces->lastItem() }} of {{ $produces->total() }}</div>
        {{ $produces->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
@endsection
