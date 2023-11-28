<nav class="navbar navbar-expand-lg bg-black mb-4 sticky-top" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand d-none" href="{{ route('admin.dashboard.index') }}">
        <span class="fw-bold py-1 bg-primary text-primary-subtle px-2">SA</span>
        <span class="fw-bold">Admin Panel</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon link-warning"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 p-lg-0 py-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard.index') ? ' text-warning-emphasis' : ' link-light' }}" aria-current="page" href="{{ route('admin.dashboard.index') }}">
                Güncel Durum
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.ticket.order.*') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.ticket.order.index') }}">
                Bilet Satışları
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.ticket') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.ticket.index') }}">
                Biletler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.customer.*') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.customer.index') }}">
                Ziyaretçiler
            </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Müzeler
          </a>
          <ul class="dropdown-menu">
            @foreach ($stores as $store)
            <li><a class="dropdown-item {{ session('adminStoreId') == $store->id ? 'active' :null }}" href="{{ route('admin.store.switch', ['storeId' => $store->id])}}">{{ $store->name }}</a></li>
            @endforeach
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('admin.store.index') }}">Tüm Müzeler</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.user.*') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.user.index') }}">
            Kullanıcılar
          </a>
        </li>
      </ul>
      <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('order.create') }}" target="_blank">
                {{ trans('Buy Panel') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user.edit', auth()->guard('admin')->id()) }}">
                {{ auth()->guard('admin')->user()->name }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ route('admin.login') }}">
                {{ trans('Logout') }}
            </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
