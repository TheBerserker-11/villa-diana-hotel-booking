<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') • Villa Diana Hotel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">
</head>
<body class="admin-body">

<div class="admin-shell">

    @include('admin.partials.sidebar')

    <div class="admin-main">
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-icon d-lg-none" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <div class="topbar-title">
                    <div class="fw-semibold">@yield('page_title', 'Dashboard')</div>
                    <div class="text-muted small">@yield('page_subtitle', 'Overview & quick stats')</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-flex align-items-center gap-2">
                    <span class="badge rounded-pill text-bg-light border">Admin</span>
                    <span class="small text-muted">{{ auth()->user()->name ?? 'admin' }}</span>
                </div>

                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> Account
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="px-3">
                                @csrf
                                <button class="btn btn-outline-danger w-100" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="admin-content">
            @yield('content')
        </div>

        <div class="admin-footer small text-muted">
            © {{ date('Y') }} Villa Diana Hotel — Admin Panel
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const toggleBtn = document.getElementById('sidebarToggle');
    const shell = document.querySelector('.admin-shell');
    if (toggleBtn && shell) {
        toggleBtn.addEventListener('click', () => shell.classList.toggle('sidebar-open'));
    }
</script>
</body>
</html>
