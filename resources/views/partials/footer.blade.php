<footer class="footer-custom">
  <div class="footer-left">
    <span class="footer-logo"><i class="bi bi-flower1"></i> AniTrade</span>
    <span class="footer-separator">|</span>
    <span class="footer-copy">&copy; {{ date('Y') }} AniTrade &bull; Farm-to-Market Produce Trading Platform</span>
  </div>
  <div class="footer-right">
    <ul class="footer-links">
      <li><a href="{{ route(auth()->user()->dashboardRoute()) }}" class="footer-link">Overview</a></li>
      <li><a href="{{ route(auth()->user()->isStore() ? 'store.orders.index' : 'buyer.orders.index') }}" class="footer-link">Orders</a></li>
      <li><a href="{{ route('account.edit') }}" class="footer-link">My Account</a></li>
    </ul>
  </div>
</footer>
