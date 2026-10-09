@php
    $user = auth()->user();

    // [route name, label, icon, active route patterns]
    $sections = ['Menu' => [[$user->dashboardRoute(), 'Dashboard', 'bi-grid-fill', [$user->dashboardRoute()]]]];

    if ($user->isStore()) {
        $sections['Store'] = [
            ['store.produce.index', 'My Produce', 'bi-basket', ['store.produce.index', 'store.produce.edit']],
            ['store.produce.create', 'Add Produce', 'bi-plus-square', ['store.produce.create']],
            ['store.orders.index', 'Orders', 'bi-receipt', ['store.orders.*']],
        ];
    } else {
        $sections['Buyer'] = [
            ['buyer.browse', 'Browse Produce', 'bi-shop', ['buyer.browse']],
            ['buyer.orders.index', 'My Orders', 'bi-receipt', ['buyer.orders.*']],
            ['buyer.stores', 'Stores', 'bi-people', ['buyer.stores']],
            ['buyer.prices', 'Price Comparison', 'bi-graph-up-arrow', ['buyer.prices']],
        ];
    }

    $sections['Account'] = [['account.edit', 'My Account', 'bi-person-gear', ['account.*']]];
@endphp

<div class="sidebar-wrapper" id="sidebar">
  <a href="{{ route($user->dashboardRoute()) }}" class="sidebar-brand">
    <i class="bi bi-flower1"></i>
    <span>AniTrade</span>
  </a>

  <div class="flex-grow-1 overflow-y-auto">
    @foreach ($sections as $title => $items)
      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">{{ $title }}</div>
        <ul class="sidebar-menu-list">
          @foreach ($items as [$routeName, $label, $icon, $patterns])
            <li class="sidebar-menu-item">
              <a href="{{ route($routeName) }}" title="{{ $label }}"
                 @class(['sidebar-menu-link', 'active' => request()->routeIs(...$patterns)])>
                <i class="bi {{ $icon }}"></i>
                <span>{{ $label }}</span>
              </a>
            </li>
          @endforeach

          @if ($title === 'Account')
            <li class="sidebar-menu-item">
              <a href="#" class="sidebar-menu-link" id="menu-logout" title="Log Out"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
              </a>
            </li>
          @endif
        </ul>
      </div>
    @endforeach
  </div>

  <div class="sidebar-profile">
    <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $user->displayName() }}" class="sidebar-profile-img">
    <div class="sidebar-profile-info">
      <div class="sidebar-profile-name">{{ $user->displayName() }}</div>
      <div class="sidebar-profile-email">{{ $user->email }}</div>
    </div>
  </div>
</div>
