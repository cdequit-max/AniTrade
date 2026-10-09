<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - AniTrade</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>
  <div class="login-wrapper">
    <div class="login-bg-shape login-bg-shape-1"></div>
    <div class="login-bg-shape login-bg-shape-2"></div>

    <div class="login-card">
      <a href="{{ url('/') }}" class="login-brand">
        <i class="bi bi-flower1"></i>
        <span>AniTrade</span>
      </a>

      @yield('content')
    </div>
  </div>

  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/auth.js') }}"></script>
  @stack('scripts')
</body>

</html>
