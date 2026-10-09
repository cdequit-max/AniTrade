@extends('layouts.app')

@section('title', 'Store Dashboard')

@section('content')
    <div class="page-header">
      <div>
        <h1 class="page-title">Store Dashboard</h1>
        <p class="page-subtitle">Sell your produce directly to buyers, with fair prices and no middlemen.</p>
      </div>
      <button class="btn-date-picker" type="button" id="date-picker-trigger">
        <i class="bi bi-calendar4-event"></i>
        <span id="selected-date-range">January 12, 2026 - January 23, 2026</span>
        <i class="bi bi-chevron-down ms-1"></i>
      </button>
    </div>
    <!-- END: Page Header -->

    <div class="row g-4">

      <!-- TOP: Stat cards -->
      <div class="col-12">
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card alert-green-card">
              <div class="position-relative z-index-2">
                <span class="alert-green-badge">Harvest Update</span>
                <div class="alert-green-date">Feb 14th 2026</div>
                <div class="alert-green-text">Tomato orders increased 40% in 1 week</div>
              </div>
              <a href="{{ route('store.orders.index') }}" class="alert-green-link z-index-2" id="alert-link-statistics">
                <span>See Statistics</span>
                <i class="bi bi-arrow-right"></i>
              </a>
              <svg class="alert-green-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g transform="translate(50,50)">
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
                </g>
              </svg>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Total Sales</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-income">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="{{ url()->current() }}"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                      <li><a class="dropdown-item" href="{{ route('store.orders.export') }}"><i class="bi bi-file-earmark-arrow-down"></i> Export Report</a></li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-eye-slash"></i> Hide Details</a></li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value">₱196,000</div>
                <div class="trend-badge trend-up">
                  <i class="bi bi-arrow-up-right"></i>
                  <span>+35% from last month</span>
                </div>
              </div>
              <div class="sparkline-container sparkline-card-footer">
                <div id="income-sparkline"></div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Cancelled Orders</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-return">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="{{ url()->current() }}"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                      <li><a class="dropdown-item" href="{{ route('store.orders.export') }}"><i class="bi bi-file-earmark-arrow-down"></i> Export Report</a></li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-eye-slash"></i> Hide Details</a></li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value">₱3,200</div>
                <div class="trend-badge trend-down">
                  <i class="bi bi-arrow-down-left"></i>
                  <span>-24% from last month</span>
                </div>
              </div>
              <div class="sparkline-container sparkline-card-footer">
                <div id="return-sparkline"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- LEFT AREA -->
      <div class="col-xl-9 col-lg-8">
        <div class="row g-4">

          <div class="col-12">
            <div class="card mb-0">
              <div class="card-header mb-2">
                <h2 class="card-title">Sales Revenue</h2>
                <div class="d-flex gap-3 align-items-center">
                  <div class="chart-legend-item">
                    <span class="legend-dot bg-forest-medium"></span>
                    <span class="chart-legend-label">Sales</span>
                  </div>
                  <div class="chart-legend-item">
                    <span class="legend-dot bg-lime-accent"></span>
                    <span class="chart-legend-label">Farm Expenses</span>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-baseline gap-2 mb-3">
                <span class="stat-value-amount">₱196,000</span>
                <span class="trend-badge trend-up fs-xs">+35% from last month</span>
              </div>
              <div id="revenue-chart"></div>
            </div>
          </div>

          <!-- Recent Orders -->
          <div class="col-md-7 d-flex flex-column">
            <div class="card h-100 flex-grow-1">
              <div class="card-header">
                <h2 class="card-title">Recent Orders</h2>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="More Options" id="btn-more-transaction">
                    <i class="bi bi-three-dots"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('store.orders.index') }}"><i class="bi bi-funnel"></i> Filter Status</a></li>
                    <li><a class="dropdown-item" href="{{ route('store.orders.export') }}"><i class="bi bi-file-earmark-arrow-down"></i> Export CSV</a></li>
                  </ul>
                </div>
              </div>

              <div class="transaction-list">
                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime">
                    <i class="bi bi-basket"></i>
                  </div>
                  <div class="transaction-info">
                    <div class="transaction-name">Fresh Tomatoes • 10 kg</div>
                    <div class="transaction-date">Maria Santos • Pending (Cash on Pickup)</div>
                  </div>
                  <div class="transaction-amount text-main">₱800.00</div>
                </div>

                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime">
                    <i class="bi bi-truck"></i>
                  </div>
                  <div class="transaction-info">
                    <div class="transaction-name">Lowland Rice • 50 kg</div>
                    <div class="transaction-date">Mindanao Coop • Paid (Delivery)</div>
                  </div>
                  <div class="transaction-amount text-success">+₱2,750.00</div>
                </div>

                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime">
                    <i class="bi bi-bag-check"></i>
                  </div>
                  <div class="transaction-info">
                    <div class="transaction-name">Bananas (Lakatan) • 25 kg</div>
                    <div class="transaction-date">Ana's Fruit Stand • Paid (Pickup)</div>
                  </div>
                  <div class="transaction-amount text-success">+₱1,500.00</div>
                </div>

                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime">
                    <i class="bi bi-cash-coin"></i>
                  </div>
                  <div class="transaction-info">
                    <div class="transaction-name">Eggplant • 8 kg</div>
                    <div class="transaction-date">Pedro Reyes • Pending (Cash on Delivery)</div>
                  </div>
                  <div class="transaction-amount text-main">₱480.00</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Produce Inventory -->
          <div class="col-md-5 d-flex flex-column">
            <div class="card h-100 flex-grow-1">
              <div class="card-header">
                <h2 class="card-title">Produce Inventory</h2>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="More Options" id="btn-more-products">
                    <i class="bi bi-three-dots"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('store.produce.create') }}"><i class="bi bi-plus-lg"></i> Add Produce</a></li>
                    <li><a class="dropdown-item" href="{{ route('store.produce.index') }}"><i class="bi bi-gear"></i> Manage</a></li>
                  </ul>
                </div>
              </div>

              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Produce Listed</span>
                  <span class="progress-value">24</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Produce Listed" aria-valuenow="65"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent w-65"></div>
                </div>
              </div>

              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Pending Orders</span>
                  <span class="progress-value">12</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Pending Orders" aria-valuenow="20"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent opacity-50 w-50"></div>
                </div>
              </div>

              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Orders Completed</span>
                  <span class="progress-value">482</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Orders Completed" aria-valuenow="85"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent w-85"></div>
                </div>
              </div>

              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Low Stock Items</span>
                  <span class="progress-value">3</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Low Stock Items" aria-valuenow="10"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-brand-orange w-38"></div>
                </div>
              </div>

              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Total Stock (kg)</span>
                  <span class="progress-value">1,420</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Total Stock" aria-valuenow="75"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent w-75"></div>
                </div>
              </div>

              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Awaiting Pickup/Delivery</span>
                  <span class="progress-value">9</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Awaiting Pickup or Delivery" aria-valuenow="45"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent opacity-50 w-45"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT AREA -->
      <div class="col-xl-3 col-lg-4">
        <div class="right-panel-wrapper d-flex flex-column gap-4 h-100">

          <div class="card flex-grow-1 d-flex flex-column justify-content-between mb-0">
            <div class="card-header mb-1">
              <h2 class="card-title">Order Status Overview</h2>
            </div>

            <div id="views-chart"></div>

            <div class="chart-legends-container">
              <div class="chart-legend-item">
                <span class="legend-dot bg-lime-accent"></span>
                <span class="text-muted-green">Paid</span>
              </div>
              <div class="chart-legend-item">
                <span class="legend-dot bg-forest-medium"></span>
                <span class="text-muted-green">Pending (COD)</span>
              </div>
              <div class="chart-legend-item">
                <span class="legend-dot bg-brand-orange"></span>
                <span class="text-muted-green">Cancelled</span>
              </div>
            </div>
          </div>

          <div class="promo-banner-card">
            <svg class="promo-banner-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g transform="translate(50,50)">
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
              </g>
            </svg>

            <h3 class="promo-title">Fresh harvest ready? List it today.</h3>
            <p class="promo-desc">Reach buyers directly, set your own price, and skip the middleman.</p>
            <button class="btn-promo" id="btn-promo-action" type="button" onclick="location.href='{{ route('store.produce.create') }}'">Add new produce</button>
          </div>
        </div>
      </div>
    </div>
@endsection
