@php
    $user = auth()->user();
    $isStore = $user->isStore();
    $searchAction = $isStore ? route('store.produce.index') : route('buyer.browse');
    $ordersRoute = $isStore ? route('store.orders.index') : route('buyer.orders.index');
@endphp

<header class="navbar-custom">
  <div class="navbar-left">
    <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
      id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
      <i class="bi bi-chevron-bar-left"></i>
    </button>
    <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
      <i class="bi bi-list"></i>
    </button>

    <div class="dropdown ms-2">
      <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
        id="quick-actions-dropdown">
        <i class="bi bi-plus-lg"></i>
        <span>Create</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-quick-action" aria-labelledby="quick-actions-dropdown">
        <li class="dropdown-header">Quick Actions</li>
        @if ($isStore)
          <li><a class="dropdown-item" href="{{ route('store.produce.create') }}"><i class="bi bi-basket"></i> New Produce Listing</a></li>
          <li><a class="dropdown-item" href="{{ route('store.orders.index') }}"><i class="bi bi-receipt"></i> View Orders</a></li>
        @else
          <li><a class="dropdown-item" href="{{ route('buyer.browse') }}"><i class="bi bi-cart-plus"></i> New Order</a></li>
          <li><a class="dropdown-item" href="{{ route('buyer.stores') }}"><i class="bi bi-person-plus"></i> Find a Store</a></li>
          <li><a class="dropdown-item" href="{{ route('buyer.prices') }}"><i class="bi bi-graph-up-arrow"></i> Compare Prices</a></li>
        @endif
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="{{ route('account.edit') }}"><i class="bi bi-gear"></i> Settings</a></li>
      </ul>
    </div>
  </div>

  <form class="navbar-search-wrapper" method="GET" action="{{ $searchAction }}">
    <input type="text" name="q" value="{{ request('q') }}" class="navbar-search-input"
      placeholder="{{ $isStore ? 'Search your produce...' : 'Search produce...' }}" id="main-search">
    <button class="navbar-search-btn" type="submit" aria-label="Search">
      <i class="bi bi-search"></i>
    </button>
  </form>

  <div class="navbar-actions">
    <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
      <i class="bi bi-arrows-fullscreen"></i>
    </button>

    <div class="dropdown">
      <button class="navbar-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false" id="btn-notifications" data-bs-auto-close="outside">
        <i class="bi bi-bell"></i>
        <span class="navbar-action-badge"></span>
      </button>
      <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification p-0" aria-labelledby="btn-notifications">
        <div class="notification-header">
          <h6 class="notification-title">Notifications</h6>
          <button class="btn-clear-all" type="button">Mark all read</button>
        </div>
        <div class="notification-list">
          @if ($isStore)
            <a href="{{ $ordersRoute }}" class="notification-item">
              <div class="notification-icon bg-success text-white"><i class="bi bi-bag-check"></i></div>
              <div class="notification-content">
                <p class="notification-text">New order: <strong>10 kg Fresh Tomatoes</strong></p>
                <span class="notification-time">2 mins ago</span>
              </div>
              <span class="notification-unread-dot"></span>
            </a>
            <a href="{{ route('store.produce.index') }}" class="notification-item">
              <div class="notification-icon bg-warning text-dark"><i class="bi bi-box-seam-fill"></i></div>
              <div class="notification-content">
                <p class="notification-text">Low stock alert: <strong>Eggplant (5 kg left)</strong></p>
                <span class="notification-time">3 hours ago</span>
              </div>
            </a>
          @else
            <a href="{{ $ordersRoute }}" class="notification-item">
              <div class="notification-icon bg-success text-white"><i class="bi bi-check2-circle"></i></div>
              <div class="notification-content">
                <p class="notification-text">Your order was <strong>confirmed</strong></p>
                <span class="notification-time">5 mins ago</span>
              </div>
              <span class="notification-unread-dot"></span>
            </a>
            <a href="{{ route('buyer.prices') }}" class="notification-item">
              <div class="notification-icon bg-warning text-dark"><i class="bi bi-tag-fill"></i></div>
              <div class="notification-content">
                <p class="notification-text">Price drop: <strong>Tomatoes now ₱75/kg</strong></p>
                <span class="notification-time">3 hours ago</span>
              </div>
            </a>
          @endif
        </div>
        <a href="{{ $ordersRoute }}" class="notification-footer">View All Orders</a>
      </div>
    </div>

    <div class="dropdown ms-2">
      <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false" id="profile-dropdown">
        <img src="{{ asset('assets/images/avatar.png') }}" alt="Profile Image" class="navbar-profile-img">
        <span class="navbar-profile-name d-none d-md-inline">{{ $user->displayName() }}</span>
        <i class="bi bi-chevron-down navbar-profile-caret"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
        <li class="dropdown-header">Welcome!</li>
        <li><a class="dropdown-item" href="{{ route('account.edit') }}"><i class="bi bi-person"></i> My Account</a></li>
        <li><a class="dropdown-item" href="{{ route('account.edit') }}#security"><i class="bi bi-gear"></i> Settings</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <button type="submit" form="logout-form" class="dropdown-item text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </li>
      </ul>
    </div>
  </div>
</header>
