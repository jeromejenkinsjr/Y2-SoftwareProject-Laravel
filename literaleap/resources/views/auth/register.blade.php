<x-guest-layout>
    <!-- Scrolling background-->
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


    <!-- Landing Section -->
    <div class="container my-5" id="landing">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border rounded-4 shadow p-4 text-center position-relative">
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

                    <!-- Google Sign-in Button -->
                    <a href="{{ route('auth.google') }}"
                        class="btn btn-light mt-4 mb-3 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/gicon.png') }}" alt="Google Logo"
                            style="width: 24px; margin-right: 8px;">
                        Sign in with Google
                    </a>

                    <!-- Registration Button -->
                    <button id="btn-register" class="btn btn-secondary w-100"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                        </svg> Register
                        with Email</button>

                    <!-- Terms & Privacy Acknowledgment -->
                    <p class="text-muted mt-5 small">
                        By signing up, you agree to our
                        <a href="{{ route('termsprivacy') }}" class="text-decoration-none">Terms & Privacy Policy</a>.
                    </p>

                    <!-- Already Have an Account? -->
                    <p class="mt-2 small">
                        Already have an account?
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form Section: Initially hidden -->
    <div class="container my-5 d-none" id="registrationForm">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="multiStepForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Step 1: Name Input -->
                    <div class="step-wrapper" data-step="0">
                        <h5 class="card-title mb-4">Firstly, what's your name?</h5>
                        <div
                            style="background: linear-gradient(45deg, #FCA714, #FF8C00, #FF1493); padding: 2px; border-radius: 10px;">
                            <div class="card"
                                style="border: 2px solid; border-image: linear-gradient(45deg, #FCA714, #FF8C00, #FF1493) 1; border-radius: 10px;">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                        <div class="invalid-feedback">Please enter your name.</div>
                                    </div>
                                    <button type="button" class="btn btn-primary next-btn">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2: Email Input -->
                    <div class="step-wrapper d-none" data-step="1">
                        <h5 class="card-title mb-4">Next up, your email! Make sure it’s one you actually check</h5>
                        <div
                            style="background: linear-gradient(45deg, #FCA714, #FF8C00, #FF1493); padding: 3px; border-radius: 5px;">
                            <div class="card" style="border: none; border-radius: 8px;">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary back-btn">Back</button>
                                        <button type="button" class="btn btn-primary next-btn">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 3: Password Input -->
                    <div class="step-wrapper d-none" data-step="2">
                        <h5 class="card-title mb-4">Time to lock things down! Choose a password even a hacker would fear
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <div class="invalid-feedback">Please provide a password.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control" required>
                                    <div class="invalid-feedback">Passwords do not match.</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary back-btn">Back</button>
                                    <button type="button" class="btn btn-primary next-btn">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 4: Profile Picture Upload -->
                    <div class="step-wrapper d-none" data-step="3">
                        <h5 class="card-title mb-4">Strike a pose! Upload your best profile pic (Optional)</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3 text-center">
                                    <img id="profile-preview" src="{{ asset('images/defaultava.jpg') }}"
                                        alt="Default Avatar" class="rounded-circle img-thumbnail"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Upload Picture</label>
                                    <input type="file" id="profile_picture" name="profile_picture" class="form-control"
                                        accept="image/*">
                                    <small class="form-text text-muted">Optional: Upload a profile picture or skip this
                                        step.</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-secondary back-btn">Back</button>
                                    <div>
                                        <button type="button" class="btn btn-link skip-btn">Skip</button>
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include external CSS and JS as needed -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <!-- External CSS for Background -->
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

    <!-- JavaScript to handle both the multi-step form and the smooth transition -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Transition from landing to registration form
        document.getElementById('btn-register').addEventListener('click', function() {
            const landing = document.getElementById('landing');
            const regForm = document.getElementById('registrationForm');
            // Hide landing section
            landing.classList.add('d-none');
            // Show registration form with a fade-in effect
            regForm.classList.remove('d-none');
            regForm.style.opacity = 0;
            setTimeout(function() {
                regForm.style.transition = "opacity 0.5s ease-in-out";
                regForm.style.opacity = 1;
            }, 50);
        });

        // Multi-step form code
        const steps = document.querySelectorAll('.step-wrapper');
        let currentStep = 0;

        function showStep(step) {
            steps.forEach((wrapper, index) => {
                wrapper.classList.toggle('d-none', index !== step);
            });
        }

        function validateStep(step) {
            let valid = true;
            const wrapper = steps[step];
            wrapper.querySelectorAll('input[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            // For password confirmation on step 3 (data-step="2")
            if (step === 2) {
                const pass = document.getElementById('password');
                const confirm = document.getElementById('password_confirmation');
                if (pass.value !== confirm.value) {
                    confirm.classList.add('is-invalid');
                    valid = false;
                } else {
                    confirm.classList.remove('is-invalid');
                }
            }
            return valid;
        }

        document.querySelectorAll('.next-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (validateStep(currentStep)) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        document.querySelectorAll('.back-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                currentStep = Math.max(0, currentStep - 1);
                showStep(currentStep);
            });
        });

        document.querySelector('.skip-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('form').submit();
        });

        // Start at step 0
        showStep(currentStep);
    });
    </script>
</x-guest-layout>