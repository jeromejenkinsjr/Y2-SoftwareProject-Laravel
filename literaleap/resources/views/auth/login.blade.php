<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="scrolling-text-rows">
        <div class="scrolling-text-container" style="top: 10%;">
            <div class="scrolling-text">
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
            </div>
        </div>
        <div class="scrolling-text-container" style="top: 30%;">
            <div class="scrolling-text">
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
            </div>
        </div>
        <div class="scrolling-text-container" style="top: 50%;">
            <div class="scrolling-text">
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
            </div>
        </div>
        <div class="scrolling-text-container" style="top: 70%;">
            <div class="scrolling-text">
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
            </div>
        </div>
        <div class="scrolling-text-container" style="top: 90%;">
            <div class="scrolling-text">
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
                <span>LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap LiteraLeap</span>
            </div>
        </div>
    </div>


    <!-- Login Section -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border rounded-4 shadow p-4 text-center position-relative"
                    style="max-width: 400px; margin: auto;">
                    <!-- Return Button -->
                    <a href="http://localhost:8000/" class="btn btn-link position-absolute top-0 start-0 m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#70747c"
                            class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1" />
                        </svg>
                    </a>
                    <!-- Centered Logo -->
                    <img src="{{ asset('images/LL_Logo_NoText.png') }}" alt="LiteraLeap Logo"
                        class="mx-auto d-block mb-3" style="width: 80px;">
                    <h2 class="mb-4">Login</h2>
                    <!-- Google Sign-in Button -->
                    <a href="{{ route('auth.google') }}"
                        class="btn btn-light mb-3 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/gicon.png') }}" alt="Google Logo"
                            style="width: 24px; margin-right: 8px;">
                        Login with Google
                    </a>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <p class="mt-3 small">
                        Don't have an account? <a href="{{ route('register') }}"
                            class="fw-bold text-decoration-none">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Scrolling Background Text */
    /* Container for all rows – fills the viewport */
    .scrolling-text-rows {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        /* so that it doesn’t interfere with other elements */
    }

    /* Each scrolling row */
    .scrolling-text-container {
        position: absolute;
        left: 0;
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
    }

    /* Scrolling text styling */
    .scrolling-text {
        display: inline-block;
        font-size: 4rem;
        font-weight: bold;
        text-transform: uppercase;
        animation: scrollText 120s linear infinite;
    }

    /* Add a gap between duplicates if needed */
    .scrolling-text span {
        margin-right: 100px;
    }

    /* Keyframes: the text moves left by 50% of its total width (because we have 2 copies) */
    @keyframes scrollText {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    /* Progressive opacity for each row */
    .scrolling-text-rows .scrolling-text-container:nth-child(1) .scrolling-text {
        color: rgba(0, 0, 0, 0.1);
        animation-delay: 0s;
    }

    .scrolling-text-rows .scrolling-text-container:nth-child(2) .scrolling-text {
        color: rgba(0, 0, 0, 0.08);
        animation-delay: -2s;
    }

    .scrolling-text-rows .scrolling-text-container:nth-child(3) .scrolling-text {
        color: rgba(0, 0, 0, 0.06);
        animation-delay: -4s;
    }

    .scrolling-text-rows .scrolling-text-container:nth-child(4) .scrolling-text {
        color: rgba(0, 0, 0, 0.04);
        animation-delay: -6s;
    }

    .scrolling-text-rows .scrolling-text-container:nth-child(5) .scrolling-text {
        color: rgba(0, 0, 0, 0.02);
        animation-delay: -8s;
    }
    </style>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>