<div class="navbar navbar-expand-lg bg-dark vh-100 border-2 w-100">

<ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link fw-bold {{ request()->routeIs('admin.dashboard.index') ? ' text-warning-emphasis' : ' link-light' }}" aria-current="page" href="{{ route('admin.dashboard.index') }}">
                {{ trans('Dashboard') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold {{ request()->routeIs('admin.order.index') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.order.index') }}">
                {{ trans('Orders') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold {{ request()->routeIs('admin.product.index') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.product.index') }}">
                {{ trans('Tickets') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold {{ request()->routeIs('admin.customer.index') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.customer.index') }}">
                {{ trans('Customers') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold {{ request()->routeIs('admin.store.index') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.store.index') }}">
                {{ trans('Museums') }}
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold {{ request()->routeIs('admin.setting.user.index') ? ' text-warning-emphasis' : ' link-light' }}" href="{{ route('admin.setting.user.index') }}">{{ trans('Settings') }}</a>
        </li>
      </ul>
</div>
