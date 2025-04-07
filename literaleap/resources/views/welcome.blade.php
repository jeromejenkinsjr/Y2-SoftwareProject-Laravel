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
        0% {
            background-position: 0% 50%;
            animation-timing-function: ease-out;
        }

        50% {
            background-position: 100% 50%;
            animation-timing-function: ease-in;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .header {
        position: relative;
        width: 100%;
        height: 600px;
        /* Adjust height as needed */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        background: linear-gradient(45deg, #1edfaa, #20d39c, #00c0f0, #00b0ff);
        background-size: 200% 200%;
        animation: gradientAnimation 5s infinite;
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
        padding: 15px;
    }

    .logo-wrapper {
        position: relative;
        /* left: 320px; Adjust this value as needed */
        display: flex;
        align-items: center;
        gap: 10px;
        /* Adjust the gap between the LL logo and the separator if needed */
    }


    .logo-separator {
        height: 30px;
        width: 3px;
        background-color: #333;
        /* Darker for visibility */
    }

    .navbar-container {

        margin: 0 auto;
        display: flex;
        align-items: center;
        width: 100%;
        padding-left: 0px;
    }

    .navbar-brand img {
        height: 25px;
    }

    .content-panel {
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    /* When "show" is added, the panel becomes visible */
    .content-panel.show {
        display: block;
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

    .modal-content {
        background-color: #2c3e50;
        /* Dark blue */
        color: white;
        /* White text for contrast */
    }
    </style>
    </style>
</head>

<body>

    <!-- Navbar-->
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
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="plansDropdown"
                                role="button" data-bs-toggle="dropdown">
                                Plans and Pricing
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Student Premium</a></li>
                                <li><a class="dropdown-item" href="#">Teacher Premium</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                id="resourcesDropdown" role="button" data-bs-toggle="dropdown">
                                Resources
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">YouTube</a></li>
                                <li><a class="dropdown-item" href="#">E-Books</a></li>
                            </ul>
                        </li>

                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link" href="#" onclick="confirmRedirect(event)">Our Projects</a>

                            <img src="{{ asset('images/github-mark.png') }}" alt="GitHub" height="25" class="ms-2">
                        </li>
                        <div class="modal fade" id="githubRedirectModal" tabindex="-1"
                            aria-labelledby="githubRedirectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!-- GitHub Logo and Title -->
                                        <h5 class="modal-title d-flex align-items-center" id="githubRedirectModalLabel">
                                            <img src="{{ asset('images/github-mark-white.png') }}" alt="GitHub Logo"
                                                height="30" class="me-2">
                                            Redirect Notice
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        You will be redirected to GitHub
                                        (<strong><u>github.com/jeromejenkinsjr</u>
                                        </strong>).
                                        Do you want to proceed?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <a id="proceedLink" href="https://github.com/jeromejenkinsjr" target="_blank"
                                            rel="noopener noreferrer" class="btn btn-light">Proceed</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>

                    <!-- Right Side: Search & User Login/Profile -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-search"></i>
                            </a>
                        </li>

                        @auth
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
                                @endphp

                                <!-- Profile Picture -->
                                <img src="{{ $profilePictureUrl }}" alt="Profile Picture" class="rounded-circle me-2"
                                    style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #000;">

                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                                </li>
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
                        @else
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <section class="header d-flex align-items-left position-relative">
        <div class="container text-start">
            <h1 class="display-3 fw-semibold text-white mb-4">LiteraLeap</h1>
            <p class="fw-5 text-white">Empowering young minds with interactive learning, engaging stories, and smart
                literacy tools.</p>

            <div class="d-flex gap-3 mt-5">
                <a href="{{ Auth::check() ? url('/dashboard') : route('register') }}"
                    class="btn btn-light btn-lg fw-bold">
                    Sign Up for Free
                </a>
                <a href="{{ Auth::check() ? url('/dashboard') : route('login') }}" class="btn btn-outline-light btn-lg">
                    Sign In
                </a>
            </div>
        </div>

        <img src="{{ asset('images/booksforbg.png') }}" alt="Books Background" class="header-bg-image">
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
                        <a class="nav-link"
                            href="http://localhost:8000/#:~:text=FAQ-,HOW%20IT%20WORKS,-Get%20the%20most">How it
                            works</a>
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

    <section style="background-color: #ffffff; padding-top: 60px; padding-bottom: 60px;">
        <div class="container">
            <!-- Headings -->
            <h6 class="mb-3 text-uppercase fw-bold text-center" style="letter-spacing: 1.25px;">How it Works</h6>
            <h2 class="text-center mb-3">Get the most from your learning experience</h2>

            <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                <button type="button" class="btn btn-warning active toggle-button" data-target="#exampleContent1">
                    Learn Through Play 🎮📚
                </button>
                <button type="button" class="btn btn-outline-warning toggle-button" data-target="#exampleContent2">
                    Watch & Read 📺📖
                </button>
                <button type="button" class="btn btn-outline-warning toggle-button" data-target="#exampleContent3">
                    Track & Improve 📊🚀
                </button>
            </div>

            <!-- Slide-in/out content container -->
            <div class="position-relative overflow-hidden mt-5">
                <!-- Panel 1 -->
                <div id="exampleContent1" class="content-panel show slide-in-right">
                    <div class="row align-items-center">
                        <div class="col-md-6 d-flex align-items-center">
                            <p class="text-muted">Interactive games make learning fun and engaging. Master English
                                through
                                storytelling, quizzes, and challenges designed to build reading and writing skills
                                naturally.</p>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('images/slide1.jpg') }}" alt="Interactive Games" class="img-fluid">
                        </div>
                    </div>
                </div>
                <!-- Panel 2 -->
                <div id="exampleContent2" class="content-panel">
                    <div class="row align-items-center">
                        <div class="col-md-6 d-flex align-items-center">
                            <p class="text-muted">Access video lessons and reading materials that complement the games.
                                Learn
                                pronunciation, sentence structure, and comprehension with visual and audio support.</p>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('images/slide2.jpg') }}" alt="Video Lessons" class="img-fluid">
                        </div>
                    </div>
                </div>
                <!-- Panel 3 -->
                <div id="exampleContent3" class="content-panel">
                    <div class="row align-items-center">
                        <div class="col-md-6 d-flex align-items-center">
                            <p class="text-muted">See your strengths and get recommendations to improve your English
                                skills step by step.</p>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('images/slide3.jpg') }}" alt="Track & Improve" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5" style="background-color: #f9f9f9;">
        <div class="container">
            <h6 class="text-center mb-3 text-uppercase fw-bold" style="letter-spacing: 1.25px;">Plans and Pricing</h6>
            <h2 class="text-center text-dark">Discover More</h2>
            <p class="text-center text-dark mb-5">Explore the world of interactive learning with LiteraLeap.</p>

            <div class="row justify-content-center">
                <!-- Teacher Premium Plan -->
                <div class="col-md-5">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h4 class="card-title">Teacher Premium</h4>
                            <p class="card-text">Empower young minds with structured curriculum tools, analytics, and
                                tailored lesson plans.</p>
                            <p class="card-text">Start with a <strong>14-day free trial</strong>. Cancel anytime before
                                you're charged.</p>
                            <h5 class="card-subtitle mb-3 text-muted">€10.99 / month</h5>

                            @auth
                            <form action="{{ route('subscribe.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="teacher">
                                <button type="submit" class="btn btn-primary btn-block w-100">Subscribe as
                                    Teacher</button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block w-100">Login to
                                Subscribe</a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Student Premium Plan -->
                <div class="col-md-5">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h4 class="card-title">Student Premium</h4>
                            <p class="card-text">Unlock full access to interactive lessons, games, and offline materials
                                to boost your literacy journey.</p>
                            <p class="card-text">Start with a <strong>14-day free trial</strong>. Cancel anytime before
                                you're charged.</p>
                            <h5 class="card-subtitle mb-3 text-muted">€4.99 / month</h5>

                            @auth
                            <form action="{{ route('subscribe.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="student">
                                <button type="submit" class="btn btn-success btn-block w-100">Subscribe as
                                    Student</button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-success btn-block w-100">Login to
                                Subscribe</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="background-color: #ffffff;">
        <div class="container">
            <h6 class="text-center mb-4  text-uppercase fw-bold" style="letter-spacing: 1.25px;">What’s New?</h6>

            <div class="row g-4">
                <!-- Left: Newest Game (full card + description) -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 overflow-hidden">
                        <div class="position-relative">
                            <!-- Ensure full image coverage -->
                            <img src="{{ asset($newestGame->thumbnail) }}" class="w-100"
                                style="height: 350px; object-fit: cover; display: block;"
                                alt="{{ $newestGame->title }}">

                            <!-- Overlay title -->
                            <div class="position-absolute bottom-0 w-100 px-3 py-2"
                                style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 50%, transparent 100%);">
                                <h1 class="text-white m-0 fw-bold">{{ $newestGame->title }}</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Game Description below the card -->
                    <p class="mt-3 mb-3 text-muted">{{ $newestGame->description }}</p>
                </div>


                <!-- Right: Featured Game & Shop Item -->
                <div class="col-md-6">
                    <div class="bg-light rounded shadow-sm p-3 h-100 d-flex flex-column justify-content-between">

                        <!-- Featured Game -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-2">Featured Game</h5>
                            @php
                            $featuredGame = \App\Models\Game::find(3);
                            @endphp
                            @if($featuredGame)
                            <div class="rounded overflow-hidden">
                                <img src="{{ asset($featuredGame->thumbnail) }}" class="img-fluid w-100"
                                    style="height: 200px; object-fit: cover;" alt="{{ $featuredGame->title }}">
                            </div>
                            @else
                            <p class="text-muted">No featured game found.</p>
                            @endif
                        </div>

                        <!-- Featured Shop Item -->
                        <div>
                            <h5 class="fw-bold mb-2">Featured Shop Item</h5>
                            @php
                            $featuredShopItem = \App\Models\ShopItem::inRandomOrder()->first();
                            @endphp
                            @if($featuredShopItem)
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset($featuredShopItem->image) }}" alt="{{ $featuredShopItem->name }}"
                                    class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $featuredShopItem->name }}</h6>
                                    <p class="text-muted small mb-0">
                                        {{ Str::limit($featuredShopItem->description, 80) }}</p>
                                </div>
                            </div>
                            @else
                            <p class="text-muted">No shop item available.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-#f9f9f9">
        <div class="container">
            <h6 class="text-center mb-3 text-uppercase fw-bold" style="letter-spacing: 1.25px;">FAQ</h6>
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>

            <div class="accordion accordion-flush" id="faqAccordion">
                <!-- Question 1 -->
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="faqHeadingOne">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseOne" aria-expanded="false" aria-controls="faqCollapseOne">
                            What is LiteraLeap?
                        </button>
                    </h2>
                    <div id="faqCollapseOne" class="accordion-collapse collapse" aria-labelledby="faqHeadingOne"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            LiteraLeap is an educational platform designed to improve literacy among young learners
                            using games, videos, and personalised tools. It's fun, intuitive, and built for all learning
                            levels.
                        </div>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="faqHeadingTwo">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                            Who is LiteraLeap for?
                        </button>
                    </h2>
                    <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            LiteraLeap is ideal for students, teachers, and guardians. Whether you're learning English
                            or teaching it, our platform offers tools and content tailored to your role.
                        </div>
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="faqHeadingThree">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                            Is there a free trial available?
                        </button>
                    </h2>
                    <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Yes! All users can enjoy a 14-day free trial of our Premium features. No credit card is
                            required to get started.
                        </div>
                    </div>
                </div>

                <!-- Question 4 -->
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="faqHeadingFour">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                            What does Premium include?
                        </button>
                    </h2>
                    <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Premium unlocks all games, offline resources, progress tracking, custom lessons (for
                            teachers), and exclusive study content. It’s the best way to maximise your LiteraLeap
                            experience.
                        </div>
                    </div>
                </div>

                <!-- Question 5 -->
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="faqHeadingFive">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseFive" aria-expanded="false" aria-controls="faqCollapseFive">
                            Can I use LiteraLeap on mobile devices?
                        </button>
                    </h2>
                    <div id="faqCollapseFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Absolutely! LiteraLeap is fully responsive and works great on phones, tablets, and desktops
                            — no app required.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row justify-content-between align-items-start">
                <!-- Left: Brand + Tagline -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">LiteraLeap®</h5>
                    <p class="small text-light mt-2">Giving every child the power to read, write, and dream beyond the
                        limits of their world.</p>
                </div>

                <!-- Center: Newsletter -->
                <div class="col-md-5 mb-4">
                    <p class="small text-light">Follow our projects and updates by subscribing to our newsletter and
                        getting all the educational scoop directly to your inbox</p>
                    <form class="d-flex mt-3">
                        <input type="email" class="form-control me-2" placeholder="Your E-Mail" required>
                        <button class="btn btn-warning fw-semibold px-4" type="submit">Subscribe</button>
                    </form>
                </div>

                <!-- Right: Social Icons -->
                <div class="col-md-2 mb-4 text-md-end">
                    <p class="small text-light mb-2">Follow Us</p>
                    <div class="d-flex gap-3 justify-content-md-end">
                        <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>

            <hr class="border-light my-4">

            <div class="text-center small text-secondary">
                Copyright © 2025 LiteraLeap. Educational Platform by Jeremi Olczak, Dublin, Ireland. All Rights
                Reserved.
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentIndex = 0;
        const buttons = document.querySelectorAll('.toggle-button');
        const panels = document.querySelectorAll('.content-panel');

        // The first button is active by default
        buttons[0].classList.add('active', 'btn-warning');
        buttons[0].classList.remove('btn-outline-warning');
        // Show the first panel by default
        panels[0].classList.add('show', 'slide-in-right');

        // Add click event to each button
        buttons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Deactivate all buttons
                buttons.forEach((b) => {
                    b.classList.remove('active', 'btn-warning');
                    b.classList.add('btn-outline-warning');
                });

                // Activate the clicked button
                button.classList.add('active', 'btn-warning');
                button.classList.remove('btn-outline-warning');

                // Hide the currently visible panel
                panels[currentIndex].classList.remove('show', 'slide-in-right',
                    'slide-in-left');

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
    <!-- JavaScript to trigger modal -->
    <script>
    function confirmRedirect(event) {
        event.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('githubRedirectModal'));
        myModal.show();
    }
    </script>
</body>

</html>