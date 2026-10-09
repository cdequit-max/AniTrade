@extends('layouts.app')

@section('title', 'My Account')

@section('content')
  <div class="page-header">
    <div>
      <h1 class="page-title">My Account</h1>
      <p class="page-subtitle">Manage your profile and password.</p>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header"><h2 class="card-title">Profile</h2></div>
        <form method="POST" action="{{ route('account.update') }}">
          @csrf @method('PUT')

          @if ($user->isStore())
            <div class="mb-3">
              <label class="form-label-custom" for="store_name">Store name</label>
              <input type="text" id="store_name" name="store_name" class="form-control-custom"
                value="{{ old('store_name', $user->store_name) }}" required>
              @error('store_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
          @endif

          <div class="mb-3">
            <label class="form-label-custom" for="name">Full name</label>
            <input type="text" id="name" name="name" class="form-control-custom" value="{{ old('name', $user->name) }}" required>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label-custom" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control-custom" value="{{ old('email', $user->email) }}" required>
            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label-custom" for="phone">Phone</label>
              <input type="text" id="phone" name="phone" class="form-control-custom" value="{{ old('phone', $user->phone) }}">
              @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label-custom" for="address">Address</label>
              <input type="text" id="address" name="address" class="form-control-custom" value="{{ old('address', $user->address) }}">
              @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
          </div>

          <button type="submit" class="btn-custom btn-custom-primary">Save Changes</button>
        </form>
      </div>
    </div>

    <div class="col-lg-5" id="security">
      <div class="card">
        <div class="card-header"><h2 class="card-title">Change Password</h2></div>
        <form method="POST" action="{{ route('account.password') }}">
          @csrf @method('PUT')

          <div class="mb-3">
            <label class="form-label-custom" for="current_password">Current password</label>
            <input type="password" id="current_password" name="current_password" class="form-control-custom" required autocomplete="current-password">
            @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label-custom" for="new_password">New password</label>
            <input type="password" id="new_password" name="password" class="form-control-custom" required autocomplete="new-password">
            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>
          <div class="mb-3">
            <label class="form-label-custom" for="new_password_confirmation">Confirm new password</label>
            <input type="password" id="new_password_confirmation" name="password_confirmation" class="form-control-custom" required autocomplete="new-password">
          </div>

          <button type="submit" class="btn-custom btn-custom-secondary">Update Password</button>
        </form>
      </div>
    </div>
  </div>
@endsection
