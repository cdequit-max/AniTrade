@extends('layouts.guest')

@section('title', 'Log In')

@section('content')
  <h1 class="login-title">Welcome back</h1>
  <p class="login-subtitle">Log in to trade fresh produce directly.</p>

  <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
    @csrf

    <div class="login-form-group">
      <label for="email" class="login-form-label">Email</label>
      <div class="login-input-group">
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="login-input"
          placeholder="you@example.com" required autofocus autocomplete="email">
        <i class="bi bi-envelope input-icon"></i>
      </div>
      @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-form-group">
      <label for="password" class="login-form-label">Password</label>
      <div class="login-input-group">
        <input type="password" id="password" name="password" class="login-input login-input-password"
          placeholder="Enter your password" required autocomplete="current-password">
        <i class="bi bi-lock input-icon"></i>
        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
          <i class="bi bi-eye"></i>
        </button>
      </div>
      @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="login-options">
      <label class="custom-control-label">
        <input type="checkbox" name="remember" class="custom-checkbox-input" value="1">
        <span>Remember me</span>
      </label>
    </div>

    <button type="submit" class="btn-login">
      <span>Log In</span> <i class="bi bi-arrow-right"></i>
    </button>
  </form>

  <p class="login-footer-text mt-4">
    New to AniTrade? <a href="{{ route('register') }}">Create an account</a>
  </p>
@endsection
