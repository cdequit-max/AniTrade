@extends('layouts.guest')

@section('title', 'Register')

@section('content')
  <h1 class="login-title">Create your account</h1>
  <p class="login-subtitle">Join AniTrade as a buyer or a store.</p>

  @php $role = old('role', request('role', 'buyer')); @endphp

  <form method="POST" action="{{ route('register') }}" novalidate>
    @csrf

    <div class="login-form-group">
      <label class="login-form-label">I want to</label>
      <div class="d-flex gap-2">
        <input type="radio" class="btn-check" name="role" id="role-buyer" value="buyer" @checked($role === 'buyer')>
        <label class="btn btn-outline-success flex-fill" for="role-buyer"><i class="bi bi-cart3"></i> Buy produce</label>
        <input type="radio" class="btn-check" name="role" id="role-store" value="store" @checked($role === 'store')>
        <label class="btn btn-outline-success flex-fill" for="role-store"><i class="bi bi-shop"></i> Sell produce</label>
      </div>
      @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-form-group" id="store-name-group">
      <label for="store_name" class="login-form-label">Store name</label>
      <div class="login-input-group">
        <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}" class="login-input"
          placeholder="e.g. Juan's Farm Store">
        <i class="bi bi-shop input-icon"></i>
      </div>
      @error('store_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-form-group">
      <label for="name" class="login-form-label">Full name</label>
      <div class="login-input-group">
        <input type="text" id="name" name="name" value="{{ old('name') }}" class="login-input"
          placeholder="Your full name" required autocomplete="name">
        <i class="bi bi-person input-icon"></i>
      </div>
      @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-form-group">
      <label for="email" class="login-form-label">Email</label>
      <div class="login-input-group">
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="login-input"
          placeholder="you@example.com" required autocomplete="email">
        <i class="bi bi-envelope input-icon"></i>
      </div>
      @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-form-group">
      <label for="phone" class="login-form-label">Phone (optional)</label>
      <div class="login-input-group">
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="login-input"
          placeholder="09xx xxx xxxx" autocomplete="tel">
        <i class="bi bi-telephone input-icon"></i>
      </div>
      @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-form-group">
      <label for="password" class="login-form-label">Password</label>
      <div class="login-input-group">
        <input type="password" id="password" name="password" class="login-input login-input-password"
          placeholder="At least 8 characters" required autocomplete="new-password">
        <i class="bi bi-lock input-icon"></i>
        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
          <i class="bi bi-eye"></i>
        </button>
      </div>
      @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-form-group">
      <label for="password_confirmation" class="login-form-label">Confirm password</label>
      <div class="login-input-group">
        <input type="password" id="password_confirmation" name="password_confirmation" class="login-input"
          placeholder="Repeat your password" required autocomplete="new-password">
        <i class="bi bi-lock-fill input-icon"></i>
      </div>
    </div>

    <button type="submit" class="btn-login mt-4">
      <span>Create Account</span> <i class="bi bi-arrow-right"></i>
    </button>
  </form>

  <p class="login-footer-text mt-4">
    Already have an account? <a href="{{ route('login') }}">Log in</a>
  </p>
@endsection

@push('scripts')
<script>
  // Show the "Store name" field only when registering as a store.
  (function () {
    const group = document.getElementById('store-name-group');
    const radios = document.querySelectorAll('input[name="role"]');
    const sync = () => {
      const isStore = document.getElementById('role-store').checked;
      group.style.display = isStore ? '' : 'none';
    };
    radios.forEach(r => r.addEventListener('change', sync));
    sync();
  })();
</script>
@endpush
