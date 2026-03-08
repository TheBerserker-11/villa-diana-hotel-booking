<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold text-uppercase" href="{{ route('home') }}">
            Villa Diana
        </a>

        <!-- Burger Button -->
        <button class="navbar-toggler" type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Rooms</a>
                </li>

                @guest
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-primary px-3"
                           href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="navbarDropdown"
                           role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="min-width:220px;">

                            <!-- My Bookings -->
                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('orders.index') }}">
                                <i class="fa-solid fa-calendar-check text-warning mr-2"></i>
                                <span>My Bookings</span>
                            </a>

                            <!-- My Profile -->
                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.show') }}">
                                <i class="fa-solid fa-user text-primary mr-2"></i>
                                <span>My Profile</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i>
                                    <span>Logout</span>
                                </button>
                            </form>

                        </div>


                    </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>
