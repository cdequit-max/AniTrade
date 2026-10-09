<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') - AniTrade</title>
  <meta name="description" content="AniTrade - A Web-Based Farm-to-Market Produce Trading Platform for Stores and Buyers">
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">

  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  @stack('styles')
</head>

<body>

  @include('partials.sidebar')

  <div class="main-wrapper">
    @include('partials.navbar')
    @include('partials.flash')

    @yield('content')

    @include('partials.footer')
  </div>

  {{-- Used by every "Log Out" button --}}
  <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>

  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  @stack('scripts')
</body>

</html>
