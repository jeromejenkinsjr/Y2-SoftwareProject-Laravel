<x-guest-layout>
    <!-- Landing Section: Two buttons -->
    <div class="container my-5" id="landing">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <!-- Button for Google Sign in -->
                <a href="{{ route('auth.google') }}" class="btn btn-light mb-3">
                    <img src="{{ asset('images/gicon.png') }}" alt="Google Logo" style="width:32px; margin-right:8px;">
                    Sign in with Google
                </a>
                <br>
                <!-- Button to show registration form -->
                <button id="btn-register" class="btn btn-secondary">Register with Email</button>
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