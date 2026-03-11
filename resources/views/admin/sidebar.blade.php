<aside class="admin-sidebar" id="adminSidebar">

    <div class="brand">
        <div class="brand-badge">
            <i class="bi bi-building"></i>
        </div>
        <div class="brand-copy">
            <div class="brand-name">Villa Diana</div>
            <div class="brand-sub">Admin Panel</div>
        </div>
    </div>

    <div class="sidebar-user">
        @php
            $adminAvatar = !empty(auth()->user()->avatar)
                ? asset('storage/' . auth()->user()->avatar)
                : asset('img/default-avatar.jpg');
        @endphp

        <div class="avatar avatar-img">
            <img src="{{ $adminAvatar }}" alt="Admin Avatar">
        </div>

        <div class="sidebar-user-meta">
            <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="user-role">Administrator</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        <a href="{{ route('admin.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.index') ? 'active':'' }}"
           data-label="Dashboard">
            <span class="sidebar-link-glow"></span>
            <span class="sidebar-icon">
                <i class="bi bi-speedometer2"></i>
            </span>
            <span class="link-text">Dashboard</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active':'' }}"
           data-label="Bookings">
            <span class="sidebar-link-glow"></span>
            <span class="sidebar-icon">
                <i class="bi bi-journal-check"></i>
            </span>
            <span class="link-text">Bookings</span>
        </a>

        <a href="{{ route('admin.events.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active':'' }}"
           data-label="Events">
            <span class="sidebar-link-glow"></span>
            <span class="sidebar-icon">
                <i class="bi bi-calendar-event"></i>
            </span>
            <span class="link-text">Events</span>
        </a>

        <a href="{{ route('admin.roomtypes.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.roomtypes.*') ? 'active':'' }}"
           data-label="Room Types">
            <span class="sidebar-link-glow"></span>
            <span class="sidebar-icon">
                <i class="bi bi-grid"></i>
            </span>
            <span class="link-text">Room Types</span>
        </a>

        <a href="{{ route('admin.rooms.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active':'' }}"
           data-label="Rooms">
            <span class="sidebar-link-glow"></span>
            <span class="sidebar-icon">
                <i class="bi bi-door-open"></i>
            </span>
            <span class="link-text">Rooms</span>
        </a>

        <a href="{{ route('admin.customers.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active':'' }}"
           data-label="Customers">
            <span class="sidebar-link-glow"></span>
            <span class="sidebar-icon">
                <i class="bi bi-people"></i>
            </span>
            <span class="link-text">Customers</span>
        </a>

        <a href="{{ route('admin.profile.show') }}"
           class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active':'' }}"
           data-label="Admin Profile">
            <span class="sidebar-link-glow"></span>
            <span class="sidebar-icon">
                <i class="bi bi-person-gear"></i>
            </span>
            <span class="link-text">Admin Profile</span>
        </a>

    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" class="w-100">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 sidebar-logout" data-label="Logout">
                <span class="sidebar-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </span>
                <span class="link-text">Logout</span>
            </button>
        </form>
    </div>

</aside>
