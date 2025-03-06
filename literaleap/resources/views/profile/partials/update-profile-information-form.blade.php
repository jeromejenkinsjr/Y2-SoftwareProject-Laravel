<section class="container p-4 bg-white shadow-sm rounded">
    <header class="mb-4">
        <h2 class="h4 fw-bold text-primary">{{ __('Profile Information') }}</h2>
        <p class="text-muted">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <!-- Display Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile Picture Upload Form -->
    <form method="POST" action="{{ route('profile.update-picture') }}" enctype="multipart/form-data" class="mb-4">
        @csrf

        <div class="mb-3 text-center">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/defaultava.jpg') }}" 
                 alt="Profile Picture" 
                 class="rounded-circle img-thumbnail shadow object-fit-cover"
                 style="width: 100px; height: 100px; object-fit: cover;">
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">{{ __('Upload New Profile Picture') }}</label>
            <input type="file" id="profile_picture" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*">
            @error('profile_picture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Hidden fields for cropping coordinates -->
        <input type="hidden" name="crop_x" id="crop_x">
        <input type="hidden" name="crop_y" id="crop_y">
        <input type="hidden" name="crop_width" id="crop_width">
        <input type="hidden" name="crop_height" id="crop_height">

        <!-- Container to display the cropping area (initially hidden) -->
        <div id="crop-container" style="display:none; margin-bottom: 1rem;">
            <h5>{{ __('Adjust your crop selection') }}</h5>
            <img id="crop-image" style="max-width: 100%;" alt="Crop Preview">
            <button type="button" id="crop-btn" class="btn btn-secondary mt-2">{{ __('Crop Image') }}</button>
        </div>

        <button type="submit" class="btn btn-primary w-100">{{ __('Update Profile Picture') }}</button>
    </form>

    <!-- Profile Information Update Form -->
    <form method="POST" action="{{ route('profile.update') }}" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PATCH')

        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success px-4">{{ __('Save Changes') }}</button>
        </div>
    </form>
</section>

<!-- Include CropperJS CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let cropper;
    const fileInput = document.getElementById('profile_picture');
    const cropContainer = document.getElementById('crop-container');
    const cropImage = document.getElementById('crop-image');
    const cropBtn = document.getElementById('crop-btn');

    fileInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = function (event) {
                cropImage.src = event.target.result;
                cropContainer.style.display = 'block';
                
                // Destroy previous cropper instance if exists
                if (cropper) {
                    cropper.destroy();
                }
                
                // Initialize CropperJS with a fixed 1:1 aspect ratio
                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                    // If needed, add additional options to lock the crop box or provide guides.
                });
            }
            reader.readAsDataURL(file);
        }
    });

    cropBtn.addEventListener('click', function () {
        if (cropper) {
            // Get cropping data
            const data = cropper.getData(true); // rounded values
            document.getElementById('crop_x').value = data.x;
            document.getElementById('crop_y').value = data.y;
            document.getElementById('crop_width').value = data.width;
            document.getElementById('crop_height').value = data.height;

            // Optionally, you can update the preview and hide the crop container
            cropContainer.style.display = 'none';
        }
    });
});
</script>
