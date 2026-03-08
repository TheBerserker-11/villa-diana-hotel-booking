{{-- =========================
    VILLA DIANA — PREMIUM HEADER
    File: resources/views/layouts/header.blade.php
========================= --}}



    <nav class="navbar navbar-expand-lg navbar-dark vd-navbar">
        <div class="container">

            <a href="{{ route('home') }}" class="navbar-brand vd-brand">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Villa Diana" class="vd-brand-logo">
                <div class="vd-brand-text d-none d-sm-block">
                    <div class="vd-brand-name">Villa Diana</div>
                    <div class="vd-brand-sub">Hotel</div>
                </div>
            </a>

            <button class="navbar-toggler vd-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">

                <div class="navbar-nav ms-auto align-items-lg-center vd-nav">

                    <a class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">Home</a>

                    <a class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">About</a>

                    <a class="nav-item nav-link {{ request()->routeIs('rooms.index') ? 'active' : '' }}"
                       href="{{ route('rooms.index') }}">Rooms</a>

                    @if(auth()->check() && auth()->user()->is_admin)
                        <a class="nav-item nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
                           href="{{ route('admin.events.index') }}">Events</a>
                    @else
                        <a class="nav-item nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}"
                           href="{{ route('events.index') }}">Events</a>
                    @endif

                    <a class="nav-item nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}"
                       href="{{ route('reviews.index') }}">Reviews</a>

                    <div class="nav-item dropdown vd-dropdown">
                        <a href="#" class="nav-link dropdown-toggle vd-dropdown-toggle {{ request()->routeIs('amenities.*') ? 'active' : '' }}"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Amenities
                        </a>

                        <div class="dropdown-menu vd-dropdown-menu">
                            <a href="{{ route('amenities.brickyard') }}" class="dropdown-item vd-dropdown-item">
                                <i class="fa fa-utensils me-2"></i> Brickyard Bar + Kitchen
                            </a>

                            <a href="{{ route('amenities.swim') }}" class="dropdown-item vd-dropdown-item">
                                <i class="fa fa-swimmer me-2"></i> Swim and Relax
                            </a>

                            <a href="{{ route('amenities.activities') }}" class="dropdown-item vd-dropdown-item">
                                <i class="fa fa-hiking me-2"></i> Activities
                            </a>
                        </div>
                    </div>

                    <a class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">Contact</a>

                    @guest
                        <a class="nav-item nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">Login</a>

                        <a class="btn btn-sm vd-btn-gold ms-lg-2 mt-2 mt-lg-0"
                           href="{{ route('register') }}">
                            Register
                        </a>
                    @else
                        <div class="d-flex align-items-center gap-2 ms-lg-2 mt-2 mt-lg-0 vd-user-tools">
                            <div class="nav-item dropdown vd-dropdown">
                                <a href="#" class="nav-link dropdown-toggle vd-dropdown-toggle" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu vd-dropdown-menu">
                                    <a href="{{ route('orders.index') }}" class="dropdown-item vd-dropdown-item">
                                        My Bookings
                                    </a>
                                    <a href="{{ route('profile') }}" class="dropdown-item vd-dropdown-item">
                                        My Profile
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <form method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item vd-dropdown-item">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if(!Auth::user()->is_admin)
                                @php
                                    $latestNotif = ($bookingNotifs ?? collect())->first();
                                    $notifMarker = ($bookingNotifCount ?? 0) > 0
                                        ? implode('|', [
                                            (string) ($bookingNotifCount ?? 0),
                                            (string) ($latestNotif->id ?? ''),
                                            (string) (optional($latestNotif?->updated_at)->timestamp ?? ''),
                                        ])
                                        : '';
                                @endphp
                                <div
                                    class="vd-notif-wrap"
                                    id="vdNotifWrap"
                                    data-user-id="{{ (int) Auth::id() }}"
                                    data-notif-marker="{{ $notifMarker }}"
                                    data-live-url="{{ route('notifications.bookings.live') }}"
                                >
                                    <button
                                        type="button"
                                        id="vdNotifToggle"
                                        class="vd-notif-btn"
                                        aria-label="Toggle booking notifications"
                                        aria-expanded="false"
                                        aria-controls="vdNotifPanel"
                                    >
                                        <i class="fa-solid fa-bell"></i>
                                        @if(($bookingNotifCount ?? 0) > 0)
                                            <span class="vd-notif-badge">
                                                {{ ($bookingNotifCount ?? 0) > 99 ? '99+' : ($bookingNotifCount ?? 0) }}
                                            </span>
                                        @endif
                                    </button>

                                    <div class="vd-notif-panel" id="vdNotifPanel" hidden>
                                        <div class="vd-notif-head">Booking Updates</div>

                                        <div id="vdNotifList">
                                            @forelse(($bookingNotifs ?? collect()) as $notif)
                                                @php
                                                    $notifStatus = strtolower((string) ($notif->status ?? ''));
                                                    $isApproved = in_array($notifStatus, ['confirmed', 'approved'], true);
                                                @endphp

                                                <div class="vd-notif-item">
                                                    <div class="vd-notif-item-title {{ $isApproved ? 'is-approved' : 'is-cancelled' }}">
                                                        {{ $isApproved ? 'Booking Approved' : 'Booking Cancelled' }}
                                                    </div>
                                                    <div class="vd-notif-item-text">
                                                        {{ $notif->room->roomtype->name ?? 'Room' }} - Ref {{ $notif->reference_code ?? 'N/A' }}
                                                    </div>
                                                    @if(!$isApproved && !empty($notif->cancel_reason))
                                                        <div class="vd-notif-item-reason">
                                                            {{ \Illuminate\Support\Str::limit($notif->cancel_reason, 100) }}
                                                        </div>
                                                    @endif
                                                    <div class="vd-notif-time">
                                                        {{ optional($notif->updated_at)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="vd-notif-empty">No booking updates yet.</div>
                                            @endforelse
                                        </div>

                                        <a href="{{ route('orders.index') }}" class="vd-notif-footer-link">View My Bookings</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.index') }}" class="btn btn-sm vd-btn-outline ms-lg-2 mt-2 mt-lg-0">
                                Admin
                            </a>
                        @endif
                    @endguest

                </div>
            </div>
        </div>
    </nav>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const wrap = document.getElementById('vdNotifWrap');
                const toggle = document.getElementById('vdNotifToggle');
                const panel = document.getElementById('vdNotifPanel');
                const list = document.getElementById('vdNotifList');
                const userId = wrap ? wrap.getAttribute('data-user-id') : '';
                const liveUrl = wrap ? (wrap.getAttribute('data-live-url') || '') : '';
                let notifMarker = wrap ? (wrap.getAttribute('data-notif-marker') || '') : '';
                const storageKey = userId ? `vd_notif_seen_${userId}` : null;

                if (!wrap || !toggle || !panel) return;

                const safeStorageGet = (key) => {
                    try {
                        return window.localStorage.getItem(key);
                    } catch (e) {
                        return null;
                    }
                };

                const safeStorageSet = (key, value) => {
                    try {
                        window.localStorage.setItem(key, value);
                    } catch (e) {
                        // Ignore storage write errors
                    }
                };

                const escapeHtml = (value) => {
                    return (value || '')
                        .toString()
                        .replaceAll('&', '&amp;')
                        .replaceAll('<', '&lt;')
                        .replaceAll('>', '&gt;')
                        .replaceAll('"', '&quot;')
                        .replaceAll("'", '&#39;');
                };

                const getBadge = () => wrap.querySelector('.vd-notif-badge');

                const setBadgeCount = (count) => {
                    const total = Number(count || 0);
                    const currentBadge = getBadge();

                    if (total <= 0) {
                        if (currentBadge) currentBadge.remove();
                        return;
                    }

                    if (!currentBadge) {
                        const nextBadge = document.createElement('span');
                        nextBadge.className = 'vd-notif-badge';
                        toggle.appendChild(nextBadge);
                    }

                    const badge = getBadge();
                    if (badge) {
                        badge.textContent = total > 99 ? '99+' : String(total);
                    }
                };

                const applyBadgeStateFromStorage = () => {
                    const badge = getBadge();
                    if (!badge) return;
                    if (!storageKey || !notifMarker) {
                        badge.hidden = !notifMarker;
                        return;
                    }
                    const seenMarker = safeStorageGet(storageKey);
                    if (seenMarker && seenMarker === notifMarker) {
                        badge.setAttribute('hidden', 'hidden');
                    } else {
                        badge.removeAttribute('hidden');
                    }
                };

                const markCurrentNotificationsSeen = () => {
                    const badge = getBadge();
                    if (!badge || !notifMarker) return;
                    badge.setAttribute('hidden', 'hidden');
                    if (storageKey) {
                        safeStorageSet(storageKey, notifMarker);
                    }
                };

                const closePanel = () => {
                    panel.setAttribute('hidden', 'hidden');
                    toggle.setAttribute('aria-expanded', 'false');
                    wrap.classList.remove('open');
                };

                const openPanel = () => {
                    panel.removeAttribute('hidden');
                    toggle.setAttribute('aria-expanded', 'true');
                    wrap.classList.add('open');
                    markCurrentNotificationsSeen();
                };

                const renderNotifItems = (items) => {
                    if (!list) return;

                    if (!Array.isArray(items) || items.length === 0) {
                        list.innerHTML = '<div class="vd-notif-empty">No booking updates yet.</div>';
                        return;
                    }

                    list.innerHTML = items.map((item) => {
                        const isApproved = !!item.is_approved;
                        const titleClass = isApproved ? 'is-approved' : 'is-cancelled';
                        const title = isApproved ? 'Booking Approved' : 'Booking Cancelled';
                        const roomName = escapeHtml(item.room_name || 'Room');
                        const referenceCode = escapeHtml(item.reference_code || 'N/A');
                        const cancelReason = escapeHtml(item.cancel_reason || '');
                        const updatedHuman = escapeHtml(item.updated_human || '');

                        return `
                            <div class="vd-notif-item">
                                <div class="vd-notif-item-title ${titleClass}">${title}</div>
                                <div class="vd-notif-item-text">${roomName} - Ref ${referenceCode}</div>
                                ${!isApproved && cancelReason ? `<div class="vd-notif-item-reason">${cancelReason}</div>` : ''}
                                <div class="vd-notif-time">${updatedHuman}</div>
                            </div>
                        `;
                    }).join('');
                };

                const syncNotifState = (payload) => {
                    const count = Number(payload?.count || 0);
                    notifMarker = payload?.marker || '';
                    wrap.setAttribute('data-notif-marker', notifMarker);

                    setBadgeCount(count);
                    renderNotifItems(payload?.items || []);

                    if (!panel.hasAttribute('hidden')) {
                        markCurrentNotificationsSeen();
                    } else {
                        applyBadgeStateFromStorage();
                    }
                };

                const fetchNotifications = async () => {
                    if (!liveUrl) return;

                    try {
                        const response = await fetch(liveUrl, {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) return;
                        const payload = await response.json();
                        syncNotifState(payload);
                    } catch (e) {
                        // Ignore polling errors to keep UI usable
                    }
                };

                applyBadgeStateFromStorage();

                toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    if (panel.hasAttribute('hidden')) {
                        openPanel();
                    } else {
                        closePanel();
                    }
                });

                document.addEventListener('click', function (event) {
                    if (!wrap.contains(event.target)) {
                        closePanel();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closePanel();
                    }
                });

                document.addEventListener('visibilitychange', function () {
                    if (!document.hidden) {
                        fetchNotifications();
                    }
                });

                if (liveUrl) {
                    fetchNotifications();
                    window.setInterval(() => {
                        if (document.hidden) return;
                        fetchNotifications();
                    }, 10000);
                }
            });
        </script>
    @endpush

</header>
