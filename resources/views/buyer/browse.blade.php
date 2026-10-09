@extends('layouts.app')

@section('title', 'Browse Produce')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">Browse Produce</h1>
      <p class="page-subtitle">Order fresh produce directly from stores. Pay cash on pickup or delivery.</p>
    </div>
  </div>

  <form method="GET" class="card mb-4">
    <div class="row g-2 align-items-end">
      <div class="col-md-5">
        <label class="form-label-custom" for="q">Search</label>
        <input type="text" id="q" name="q" value="{{ request('q') }}" class="form-control-custom" placeholder="e.g. tomatoes">
      </div>
      <div class="col-md-4">
        <label class="form-label-custom" for="category">Category</label>
        <select id="category" name="category" class="form-select-custom">
          <option value="">All categories</option>
          @foreach (\App\Models\Produce::CATEGORIES as $c)
            <option value="{{ $c }}" @selected(request('category') === $c)>{{ $c }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        @if (request('store')) <input type="hidden" name="store" value="{{ request('store') }}"> @endif
        <button type="submit" class="btn-custom btn-custom-primary flex-fill">Filter</button>
        <a href="{{ route('buyer.browse') }}" class="btn-custom btn-custom-light">Reset</a>
      </div>
    </div>
  </form>

  <div class="row g-4">
    @forelse ($produces as $p)
      <div class="col-md-6 col-xl-4">
        <div class="card h-100">
          <div class="card-header">
            <h2 class="card-title">{{ $p->name }}</h2>
            <span class="badge-table success">{{ $p->category }}</span>
          </div>

          <p class="mb-1"><i class="bi bi-shop"></i> {{ $p->store?->displayName() ?? 'Unknown store' }}</p>
          <div class="stat-value-amount mb-1">₱{{ number_format($p->price, 2) }} <small>/ {{ $p->unit }}</small></div>
          <p class="small mb-3">{{ number_format($p->stock) }} {{ $p->unit }} available</p>
          @if ($p->description) <p class="small">{{ \Illuminate\Support\Str::limit($p->description, 90) }}</p> @endif

          <form method="POST" action="{{ route('buyer.orders.store') }}" class="mt-auto">
            @csrf
            <input type="hidden" name="produce_id" value="{{ $p->id }}">
            <div class="row g-2 mb-2">
              <div class="col-5">
                <input type="number" name="quantity" min="1" max="{{ $p->stock }}" step="1"
                  value="{{ old('produce_id') == $p->id ? old('quantity') : 1 }}"
                  class="form-control-custom" aria-label="Quantity ({{ $p->unit }})" required>
              </div>
              <div class="col-7">
                <select name="fulfillment" class="form-select-custom" aria-label="Pickup or delivery">
                  <option value="pickup">Pickup</option>
                  <option value="delivery">Delivery</option>
                </select>
              </div>
            </div>

            {{-- Order note (optional) --}}
            <input type="text" name="notes" maxlength="255"
              value="{{ old('produce_id') == $p->id ? old('notes') : '' }}"
              class="form-control-custom mb-2" placeholder="Add a note (optional)" aria-label="Order note">
            @if (old('produce_id') == $p->id) @error('notes') <div class="text-danger small mb-2">{{ $message }}</div> @enderror @endif

            @if (old('produce_id') == $p->id) @error('quantity') <div class="text-danger small mb-2">{{ $message }}</div> @enderror @endif
            <button type="submit" class="btn-custom btn-custom-primary w-100">
              <i class="bi bi-cart-plus"></i> Place Order
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-12"><div class="card text-center py-4">No produce matches your search.</div></div>
    @endforelse
  </div>

  <div class="mt-4">{{ $produces->links('pagination::bootstrap-5') }}</div>
@endsection