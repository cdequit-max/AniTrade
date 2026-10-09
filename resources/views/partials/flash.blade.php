@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@foreach (array_merge($errors->get('order'), $errors->get('quantity')) as $message)
  <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i> {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endforeach
