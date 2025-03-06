<x-guest-layout>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form id="multiStepForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
          @csrf
          <!-- Step 1: Name Input -->
          <h5 class="card-title mb-4">What's your first name?</h5>
          <div class="card step-card" data-step="1">
            <div class="card-body">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
                <div class="invalid-feedback">Please enter your name.</div>
              </div>
              <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>
          </div>

          <!-- Step 2: Email Input -->
          <div class="card step-card d-none" data-step="2">
            <div class="card-body">
              <h5 class="card-title mb-4">Step 2: Your Email</h5>
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

          <!-- Step 3: Password Input -->
          <div class="card step-card d-none" data-step="3">
            <div class="card-body">
              <h5 class="card-title mb-4">Step 3: Set Your Password</h5>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="invalid-feedback">Please provide a password.</div>
              </div>
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                <div class="invalid-feedback">Passwords do not match.</div>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary back-btn">Back</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
              </div>
            </div>
          </div>

          <!-- Step 4: Profile Picture Upload -->
          <div class="card step-card d-none" data-step="4">
            <div class="card-body">
              <h5 class="card-title mb-4">Step 4: Upload Profile Picture (Optional)</h5>
              <div class="mb-3 text-center">
                <img id="profile-preview" src="{{ asset('images/defaultava.jpg') }}" 
                     alt="Default Avatar" 
                     class="rounded-circle img-thumbnail" 
                     style="width: 100px; height: 100px; object-fit: cover;">
              </div>
              <div class="mb-3">
                <label for="profile_picture" class="form-label">Upload Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*">
                <small class="form-text text-muted">Optional: Upload a profile picture or skip this step.</small>
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
        </form>
      </div>
    </div>
  </div>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function(){
      const steps = document.querySelectorAll('.step-card');
      let currentStep = 0;

      // Show current step; hide others
      function showStep(step) {
        steps.forEach((card, index) => {
          card.classList.toggle('d-none', index !== step);
        });
      }

      // Basic validation for current step
      function validateStep(step) {
        let valid = true;
        const card = steps[step];
        card.querySelectorAll('input[required]').forEach(input => {
          if (!input.value.trim()) {
            input.classList.add('is-invalid');
            valid = false;
          } else {
            input.classList.remove('is-invalid');
          }
        });
        // Check password confirmation on step 3
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

      // Next buttons: Validate then advance
      document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
          }
        });
      });

      // Back buttons: Go to previous step
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

      showStep(currentStep);
    });
  </script>
</x-guest-layout>
