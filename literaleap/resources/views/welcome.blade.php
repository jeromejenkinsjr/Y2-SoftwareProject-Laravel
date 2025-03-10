<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraLeap | Getting Started</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>

@keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .header {
            position: relative;
            width: 100%;
            height: 600px; /* Adjust height as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            background: linear-gradient(45deg, #FCA714, #FF8C00, #FF1493);
            background-size: 200% 200%;
            animation: gradientAnimation 20s infinite alternate ease-in-out;
            overflow: hidden;
        }

        .header-bg-image {
    position: absolute;
    right: 0;
    bottom: 0;
    height: 100%;
    object-fit: cover;
    z-index: 1;
}

        /* Wave Effect */
        .header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: url('https://www.shapedivider.app/svg/wave-haikei.svg') no-repeat center bottom;
            background-size: cover;
        }

        /* Custom Styling */
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px ; 
        }
        .logo-wrapper {
            position: relative;
            /* left: 320px; Adjust this value as needed */
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

        .content-panel {
            position: absolute;
            width: 100%;
            top: 0;
            left: 100%;
            opacity: 0;
            transition: all 0.5s ease;
}

/* When "show" is added, the panel becomes visible */
.content-panel.show {
  opacity: 1;
}

/* Slide in from the right */
.content-panel.slide-in-right {
  left: 0;
}

/* Slide in from the left */
.content-panel.slide-in-left {
  left: 0;
}
</style>
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid d-flex align-items-center">
            <!-- Left Side: Logo + Separator -->
            <div class="logo-wrapper">
                <img src="{{ asset('images/LL_Logo_NoText.png') }}" alt="LiteraLeap Logo" height="45">
                <div class="logo-separator"></div> <!-- Vertical Line -->
            </div>

            <div class="container navbar-container">
                <!-- Brand Name Positioned Beside the Separator -->
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('images/Text_LiteraLeap.png') }}" alt="LiteraLeap" height="30">
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

    <section class="header d-flex align-items-left position-relative">
    <div class="container text-start">
        <h1 class="display-3 fw-semibold text-white mb-4">LiteraLeap</h1>
        <p class="fw-5 text-white">Empowering young minds with interactive learning, engaging stories, and smart literacy tools.</p>
        
        <div class="d-flex gap-3 mt-5">
            <a href="{{ Auth::check() ? url('/dashboard') : route('register') }}" class="btn btn-light btn-lg fw-bold">
                Sign Up for Free
            </a>
            <a href="{{ Auth::check() ? url('/dashboard') : route('login') }}" class="btn btn-outline-light btn-lg">
                Sign In
            </a>
        </div>
    </div>

    <img src="{{ asset('images/booksforbg.png') }}" alt="Books Background"
        class="header-bg-image">
</section>

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <!-- Toggle button for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#secondNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="secondNavbar">
            <ul class="navbar-nav gap-5">
                <li class="nav-item ">
                    <a class="nav-link" href="#">How it works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">What’s new</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Plans & pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section>
<div class="container">
    <!-- Headings -->
    <h6 class="mt-5 mb-3 text-uppercase fw-bold" style="letter-spacing: 1.25px;">How it Works</h6>
    <h2 class="mt-4">Get the most from your learning experience</h2>

    <div class="mt-5 d-flex gap-3">
    <button type="button" class="btn btn-primary active toggle-button" data-target="#exampleContent1">
        First
    </button>
    <button type="button" class="btn btn-outline-primary toggle-button" data-target="#exampleContent2">
        Second
    </button>
    <button type="button" class="btn btn-outline-primary toggle-button" data-target="#exampleContent3">
        Third
    </button>
    </div>

    <!-- Slide-in/out content container -->
    <div class="position-relative overflow-hidden mt-4" style="height: 150px;">
    <div id="exampleContent1" class="content-panel show slide-in-right">
        <p class="text-muted">This is the first content section. It's displayed by default.</p>
    </div>
    <div id="exampleContent2" class="content-panel">
        <p class="text-muted">This is the second content section. It appears when the second button is clicked.</p>
    </div>
    <div id="exampleContent3" class="content-panel">
        <p class="text-muted">This is the third content section. It appears when the third button is clicked.</p>
    </div>
    </div>
</div>
</section>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
  let currentIndex = 0;
  const buttons = document.querySelectorAll('.toggle-button');
  const panels = document.querySelectorAll('.content-panel');

  // The first button is active by default
  buttons[0].classList.add('active', 'btn-primary');
  buttons[0].classList.remove('btn-outline-primary');
  // Show the first panel by default
  panels[0].classList.add('show', 'slide-in-right');

  // Add click event to each button
  buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
      // Deactivate all buttons
      buttons.forEach((b) => {
        b.classList.remove('active', 'btn-primary');
        b.classList.add('btn-outline-primary');
      });

      // Activate the clicked button
      button.classList.add('active', 'btn-primary');
      button.classList.remove('btn-outline-primary');

      // Hide the currently visible panel
      panels[currentIndex].classList.remove('show', 'slide-in-right', 'slide-in-left');

      // Decide slide direction based on index
      if (index > currentIndex) {
        panels[index].classList.add('slide-in-right');
      } else {
        panels[index].classList.add('slide-in-left');
      }

      // Show the new panel
      panels[index].classList.add('show');
      currentIndex = index;
    });
  });
});
</script>

</body>
</html>
