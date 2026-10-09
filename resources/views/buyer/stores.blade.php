@extends('layouts.app')

@section('title', 'Stores')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">Stores</h1>
      <p class="page-subtitle">Local stores selling fresh produce on AniTrade.</p>
    </div>
  </div>

  <div class="row g-4">
    @forelse ($stores as $store)
      <div class="col-md-6 col-xl-4">
        <div class="card h-100">
          <div class="card-header">
            <h2 class="card-title">{{ $store->displayName() }}</h2>
            <span class="badge-table success">{{ $store->listed_count }} listed</span>
          </div>
          <p class="mb-1"><i class="bi bi-person"></i> {{ $store->name }}</p>
          @if ($store->phone) <p class="mb-1"><i class="bi bi-telephone"></i> {{ $store->phone }}</p> @endif
          @if ($store->address) <p class="mb-1"><i class="bi bi-geo-alt"></i> {{ $store->address }}</p> @endif
          <a href="{{ route('buyer.browse', ['store' => $store->id]) }}" class="btn-custom btn-custom-primary mt-auto">
            <i class="bi bi-basket"></i> View Produce
          </a>
        </div>
      </div>
    @empty
      <div class="col-12"><div class="card text-center py-4">No stores have joined yet.</div></div>
    @endforelse
  </div>

  <div class="mt-4">{{ $stores->links('pagination::bootstrap-5') }}</div>
@endsection
