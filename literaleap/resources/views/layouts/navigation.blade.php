<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/LL_Logo_NoText.png') }}" alt="Logo" height="40">
        </a>

        <!-- Hamburger Menu (Mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('games.index') ? 'active' : '' }}"
                        href="{{ route('games.index') }}">{{ __('Games') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}"
                        href="{{ route('shop') }}">{{ __('Shop') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('forum.index') ? 'active' : '' }}"
                        href="{{ route('forum.index') }}">{{ __('Forums') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}"
                        href="{{ route('teams.index') }}">{{ __('Teams') }}</a>
                </li>
                <form action="{{ route('search') }}" method="GET" class="d-flex ms-auto" role="search">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search site..."
                        aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </ul>

            <!-- User Dropdown with Profile Picture -->
            @auth
            <ul class="navbar-nav ms-auto">
                <a href="{{ route('subscribe') }}">
                    <button class="btn button-gradient-border">
                        Subscribe
                    </button>
                </a>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @php
                        $profilePicture = Auth::user()->profile_picture;
                        $profilePictureUrl = $profilePicture
                        ? (\Illuminate\Support\Str::startsWith($profilePicture, 'images/')
                        ? asset($profilePicture)
                        : asset('storage/' . $profilePicture))
                        : asset('images/defaultava.jpg');

                        // Retrieve user's selected profile icon (20x20) from purchased icons
                        $userIcons = Auth::user()->shopItems->where('type', 'icon');
                        $selectedIcon = Auth::user()->profile_icon
                        ? $userIcons->where('image', Auth::user()->profile_icon)->first()
                        : null;
                        $profileIconUrl = $selectedIcon ? asset($selectedIcon->image) :
                        asset('images/default-icon.png');
                        @endphp

                        <!-- Profile Picture -->
                        <img src="{{ $profilePictureUrl }}" alt="Profile Picture" class="rounded-circle me-2"
                            style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #000;">

                        {{ Auth::user()->name }}

                        <!-- Selected Icon (20x20) beside the user's name -->
                        @if($selectedIcon && !empty(Auth::user()->profile_icon))
                        <img src="{{ $profileIconUrl }}" alt="Profile Icon" class="rounded-circle ms-2"
                            style="width: 20px; height: 20px; object-fit: cover;">
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

            @endauth
        </div>
    </div>
</nav>