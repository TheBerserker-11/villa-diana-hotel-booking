<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin • Villa Diana Hotel</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Admin Modern CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">
</head>

<body class="admin-body">

<div class="admin-shell theme-dark" id="adminShell">

    {{-- Mobile overlay --}}
    <div class="admin-overlay" id="adminOverlay" aria-hidden="true"></div>

    {{-- Sidebar --}}
    @include('admin.sidebar')

    {{-- Main --}}
    <div class="admin-main">

        {{-- Topbar --}}
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-2 gap-sm-3 admin-topbar-start">
                <button class="btn btn-icon d-lg-none" id="sidebarToggle" type="button">
                    <i class="bi bi-list"></i>
                </button>

                <button class="btn btn-icon d-none d-lg-inline-flex" id="sidebarCollapse" type="button" title="Collapse sidebar">
                    <i class="bi bi-layout-sidebar-inset"></i>
                </button>

                <div class="min-w-0">
                    <h5 class="mb-0 text-truncate">@yield('title', 'Dashboard')</h5>
                    <small class="text-muted d-none d-sm-block">Villa Diana Hotel Admin</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 admin-topbar-actions">

                {{-- Theme toggle --}}
                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted d-none d-md-inline" id="themeLabel">Dark</small>

                    <label class="vd-theme-switch" title="Toggle theme">
                        <input id="themeToggle" type="checkbox" />
                        <div class="slider round">
                            <div class="sun-moon">
                                <svg id="moon-dot-1" class="moon-dot" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="moon-dot-2" class="moon-dot" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="moon-dot-3" class="moon-dot" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>

                                <svg id="light-ray-1" class="light-ray" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="light-ray-2" class="light-ray" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="light-ray-3" class="light-ray" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>

                                <svg id="cloud-1" class="cloud-dark" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="cloud-2" class="cloud-dark" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="cloud-3" class="cloud-dark" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>

                                <svg id="cloud-4" class="cloud-light" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="cloud-5" class="cloud-light" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                                <svg id="cloud-6" class="cloud-light" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
                            </div>

                            <div class="stars">
                                <svg id="star-1" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                                <svg id="star-2" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                                <svg id="star-3" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                                <svg id="star-4" class="star" viewBox="0 0 20 20"><path d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"></path></svg>
                            </div>
                        </div>
                    </label>
                </div>

            </div>
        </div>

        {{-- Page content --}}
        <div class="admin-content">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="admin-footer small text-muted">
            © {{ date('Y') }} Villa Diana Hotel
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Sidebar (mobile open + collapse) --}}
<script>
(() => {
    const shell = document.getElementById('adminShell');
    const overlay = document.getElementById('adminOverlay');

    const openBtn = document.getElementById('sidebarToggle');
    const collapseBtn = document.getElementById('sidebarCollapse');

    const KEY = 'vd_admin_sidebar_collapsed';

    try {
        if (localStorage.getItem(KEY) === '1') shell?.classList.add('is-collapsed');
    } catch(e){}

    function openMobile(){
        shell?.classList.add('sidebar-open');
        overlay?.setAttribute('aria-hidden','false');
    }
    function closeMobile(){
        shell?.classList.remove('sidebar-open');
        overlay?.setAttribute('aria-hidden','true');
    }

    
    document.querySelectorAll('.admin-sidebar a').forEach(a => {
        a.addEventListener('click', () => closeMobile());
    });

    
    if (shell?.classList.contains('sidebar-open') && window.innerWidth >= 992) {
        closeMobile();
    }
    function toggleCollapse(){
        shell?.classList.toggle('is-collapsed');
        try {
            localStorage.setItem(KEY, shell?.classList.contains('is-collapsed') ? '1' : '0');
        } catch(e){}
    }

    openBtn?.addEventListener('click', () => {
        if (shell?.classList.contains('sidebar-open')) {
            closeMobile();
        } else {
            openMobile();
        }
    });
    overlay?.addEventListener('click', closeMobile);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMobile(); });

    collapseBtn?.addEventListener('click', toggleCollapse);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) closeMobile();
    });
})();
</script>

{{-- Theme toggle --}}
<script>
(() => {
    const shell = document.getElementById('adminShell');
    const toggle = document.getElementById('themeToggle');
    const label = document.getElementById('themeLabel');

    const THEME_KEY = 'vd_admin_theme';

    function applyTheme(theme){
        if (!shell) return;

        const isLight = theme === 'light';

        shell.classList.toggle('theme-light', isLight);
        shell.classList.toggle('theme-dark', !isLight);

        document.documentElement.classList.toggle('light', isLight);
        document.body.classList.toggle('light', isLight);

        if (toggle) toggle.checked = !isLight; 
        if (label) label.textContent = isLight ? 'Light' : 'Dark';
    }

    let saved = 'dark';
    try { saved = localStorage.getItem(THEME_KEY) || 'dark'; } catch(e){}
    applyTheme(saved);

    toggle?.addEventListener('change', () => {
        const next = toggle.checked ? 'dark' : 'light';
        applyTheme(next);
        try { localStorage.setItem(THEME_KEY, next); } catch(e){}
    });
})();
</script>

{{-- ✅ Client-side "search as you type" for Customer Management (no reload) --}}
<script>
(() => {
    
    const input = document.getElementById('customerSearch');
    if (!input) return;

    const rows  = Array.from(document.querySelectorAll('.customer-row'));
    const cards = Array.from(document.querySelectorAll('.customer-card'));

    function normalize(s){
        return (s || '').toString().toLowerCase().trim();
    }

    function applyFilter(){
        const term = normalize(input.value);

        
        rows.forEach(el => {
            const hay = normalize(el.dataset.search || el.innerText);
            el.style.display = hay.includes(term) ? '' : 'none';
        });

        
        cards.forEach(el => {
            const hay = normalize(el.dataset.search || el.innerText);
            el.style.display = hay.includes(term) ? '' : 'none';
        });
    }

    
    input.addEventListener('input', applyFilter);

    
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') e.preventDefault();
    });

    
    applyFilter();
})();
</script>

</body>
</html>
