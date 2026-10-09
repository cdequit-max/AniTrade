@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
    <div class="page-header">
      <div>
        <h1 class="page-title">Buyer Dashboard</h1>
        <p class="page-subtitle">Buy fresh produce straight from local stores at fair, transparent prices.</p>
      </div>
      <button class="btn-date-picker" type="button" id="date-picker-trigger">
        <i class="bi bi-calendar4-event"></i>
        <span id="selected-date-range">January 12, 2026 - January 23, 2026</span>
        <i class="bi bi-chevron-down ms-1"></i>
      </button>
    </div>

    <div class="row g-4">

      <!-- Stat cards -->
      <div class="col-12">
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card alert-green-card">
              <div class="position-relative z-index-2">
                <span class="alert-green-badge">Market Update</span>
                <div class="alert-green-date">Feb 14th 2026</div>
                <div class="alert-green-text">12 new produce listings from stores near you</div>
              </div>
              <a href="{{ route('buyer.browse') }}" class="alert-green-link z-index-2" id="alert-link-statistics">
                <span>Browse Produce</span><i class="bi bi-arrow-right"></i>
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
                  <span class="stat-label">Total Purchases</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-income"><i class="bi bi-three-dots"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="{{ url()->current() }}"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                      <li><a class="dropdown-item" href="{{ route('buyer.orders.export') }}"><i class="bi bi-file-earmark-arrow-down"></i> Export Report</a></li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value">₱84,500</div>
                <div class="trend-badge trend-up">
                  <i class="bi bi-arrow-up-right"></i><span>+18% from last month</span>
                </div>
              </div>
              <div class="sparkline-container sparkline-card-footer"><div id="income-sparkline"></div></div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Savings vs. Middlemen</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-return"><i class="bi bi-three-dots"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="{{ url()->current() }}"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                      <li><a class="dropdown-item" href="{{ route('buyer.orders.export') }}"><i class="bi bi-file-earmark-arrow-down"></i> Export Report</a></li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value">₱12,300</div>
                <div class="trend-badge trend-up">
                  <i class="bi bi-arrow-up-right"></i><span>+9% from last month</span>
                </div>
              </div>
              <div class="sparkline-container sparkline-card-footer"><div id="return-sparkline"></div></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Left area -->
      <div class="col-xl-9 col-lg-8">
        <div class="row g-4">

          <div class="col-12">
            <div class="card mb-0">
              <div class="card-header mb-2">
                <h2 class="card-title">Purchase History</h2>
                <div class="d-flex gap-3 align-items-center">
                  <div class="chart-legend-item">
                    <span class="legend-dot bg-forest-medium"></span>
                    <span class="chart-legend-label">Amount Spent</span>
                  </div>
                  <div class="chart-legend-item">
                    <span class="legend-dot bg-lime-accent"></span>
                    <span class="chart-legend-label">Savings</span>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-baseline gap-2 mb-3">
                <span class="stat-value-amount">₱84,500</span>
                <span class="trend-badge trend-up fs-xs">+18% from last month</span>
              </div>
              <div id="revenue-chart"></div>
            </div>
          </div>

          <!-- My Recent Orders -->
          <div class="col-md-7 d-flex flex-column">
            <div class="card h-100 flex-grow-1">
              <div class="card-header">
                <h2 class="card-title">My Recent Orders</h2>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="More Options" id="btn-more-transaction"><i class="bi bi-three-dots"></i></button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('buyer.orders.index') }}"><i class="bi bi-funnel"></i> Filter Status</a></li>
                    <li><a class="dropdown-item" href="{{ route('buyer.orders.export') }}"><i class="bi bi-file-earmark-arrow-down"></i> Export CSV</a></li>
                  </ul>
                </div>
              </div>

              <div class="transaction-list">
                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime"><i class="bi bi-basket"></i></div>
                  <div class="transaction-info">
                    <div class="transaction-name">Fresh Tomatoes • 10 kg</div>
                    <div class="transaction-date">Juan's Farm Store • Pending (Cash on Pickup)</div>
                  </div>
                  <div class="transaction-amount text-main">₱800.00</div>
                </div>
                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime"><i class="bi bi-truck"></i></div>
                  <div class="transaction-info">
                    <div class="transaction-name">Lowland Rice • 50 kg</div>
                    <div class="transaction-date">Pedro's Farm Store • Out for Delivery</div>
                  </div>
                  <div class="transaction-amount text-main">₱2,750.00</div>
                </div>
                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime"><i class="bi bi-bag-check"></i></div>
                  <div class="transaction-info">
                    <div class="transaction-name">Bananas (Lakatan) • 25 kg</div>
                    <div class="transaction-date">Ana's Farm Store • Paid (Pickup)</div>
                  </div>
                  <div class="transaction-amount text-success">₱1,500.00</div>
                </div>
                <div class="transaction-item">
                  <div class="transaction-icon bg-forest-light text-lime"><i class="bi bi-cash-coin"></i></div>
                  <div class="transaction-info">
                    <div class="transaction-name">Eggplant • 8 kg</div>
                    <div class="transaction-date">Luis's Farm Store • Paid (Delivery)</div>
                  </div>
                  <div class="transaction-amount text-success">₱480.00</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Top Suppliers -->
          <div class="col-md-5 d-flex flex-column">
            <div class="card h-100 flex-grow-1">
              <div class="card-header">
                <h2 class="card-title">Top Stores</h2>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="More Options" id="btn-more-products"><i class="bi bi-three-dots"></i></button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('buyer.stores') }}"><i class="bi bi-people"></i> View All Stores</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-heart"></i> Favorites</a></li>
                  </ul>
                </div>
              </div>

              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Juan's Farm Store (Tomatoes)</span>
                  <span class="progress-value">₱24,000</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Juan's Farm Store" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent w-85"></div>
                </div>
              </div>
              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Pedro's Farm Store (Rice)</span>
                  <span class="progress-value">₱20,500</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Pedro's Farm Store" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent w-75"></div>
                </div>
              </div>
              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Ana's Farm Store (Bananas)</span>
                  <span class="progress-value">₱15,000</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Ana's Farm Store" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent w-65"></div>
                </div>
              </div>
              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Luis's Farm Store (Vegetables)</span>
                  <span class="progress-value">₱9,800</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Luis's Farm Store" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent opacity-50 w-45"></div>
                </div>
              </div>
              <div class="progress-container">
                <div class="progress-label-row">
                  <span class="progress-label">Rosa's Farm Store (Corn)</span>
                  <span class="progress-value">₱6,400</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Rosa's Farm Store" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-brand-orange w-38"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right area -->
      <div class="col-xl-3 col-lg-4">
        <div class="right-panel-wrapper d-flex flex-column gap-4 h-100">
          <div class="card flex-grow-1 d-flex flex-column justify-content-between mb-0">
            <div class="card-header mb-1">
              <h2 class="card-title">My Order Status</h2>
            </div>
            <div id="views-chart"></div>
            <div class="chart-legends-container">
              <div class="chart-legend-item">
                <span class="legend-dot bg-lime-accent"></span>
                <span class="text-muted-green">Completed</span>
              </div>
              <div class="chart-legend-item">
                <span class="legend-dot bg-forest-medium"></span>
                <span class="text-muted-green">Pending / In Transit</span>
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
            <h3 class="promo-title">Shop fresh local produce today.</h3>
            <p class="promo-desc">Compare prices across stores and order directly.</p>
            <button class="btn-promo" id="btn-promo-action" type="button" onclick="location.href='{{ route('buyer.browse') }}'">Browse produce now</button>
          </div>
        </div>
      </div>
    </div>
@endsection
