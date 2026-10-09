@extends('layouts.app')

@section('title', 'Add Produce')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">Add Produce</h1>
      <p class="page-subtitle">List a new item for buyers to order.</p>
    </div>
  </div>

  <div class="card">
    <form method="POST" action="{{ route('store.produce.store') }}">
      @csrf
      @include('store.produce._form')
    </form>
  </div>
@endsection
