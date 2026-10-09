@extends('layouts.app')

@section('title', 'Edit Produce')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">Edit Produce</h1>
      <p class="page-subtitle">Update price, stock or details for {{ $produce->name }}.</p>
    </div>
  </div>

  <div class="card">
    <form method="POST" action="{{ route('store.produce.update', $produce) }}">
      @csrf @method('PUT')
      @include('store.produce._form')
    </form>
  </div>
@endsection
