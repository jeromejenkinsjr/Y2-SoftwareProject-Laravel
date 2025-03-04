<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraLeap</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Custom Styling */
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo-wrapper {
    position: relative;
    left: 335px; /* Adjust this value as needed */
    display: flex;
    align-items: center;
    gap: 10px; /* Adjust the gap between the LL logo and the separator if needed */
}


        .logo-separator {
            height: 30px;
            width: 3px;
            background-color: #333; /* Darker for visibility */
        }
        .navbar-container {
        
            margin: 0 auto;
            display: flex;
            align-items: center;
            width: 100%;
            padding-left:0px;
        }
        .navbar-brand img {
            height: 25px;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid d-flex align-items-center">
            <!-- Left Side: Logo + Separator -->
            <div class="logo-wrapper">
                <img src="{{ asset('images/LL_Logo_NoText.png') }}" alt="LiteraLeap Logo" height="40">
                <div class="logo-separator"></div> <!-- Vertical Line -->
            </div>

            <div class="container navbar-container">
                <!-- Brand Name Positioned Beside the Separator -->
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('images/Text_LiteraLeap.png') }}" alt="LiteraLeap">
                </a>

                <!-- Navbar Toggle for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <!-- Left Side: Navigation Links -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="plansDropdown" role="button" data-bs-toggle="dropdown">
                                Plans and Pricing 
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Basic Plan</a></li>
                                <li><a class="dropdown-item" href="#">Premium Plan</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="resourcesDropdown" role="button" data-bs-toggle="dropdown">
                                Resources 
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Blog</a></li>
                                <li><a class="dropdown-item" href="#">Help Center</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Our Projects</a>
                        </li>
                    </ul>

                    <!-- Right Side: Search & User Login/Name -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-search"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            @auth
                                <a class="nav-link fw-bold" href="{{ url('/dashboard') }}">
                                    {{ Auth::user()->name }}
                                </a>
                            @else
                                <a class="nav-link fw-bold" href="{{ route('login') }}">
                                    Login
                                </a>
                            @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
