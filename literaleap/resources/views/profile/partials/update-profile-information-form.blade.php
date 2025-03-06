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
    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('default-avatar.png') }}" 
         alt="Profile Picture" 
         class="rounded-circle img-thumbnail shadow object-fit-cover"
         style="width: 100px; height: 100px; object-fit: cover;">
</div>


        <div class="mb-3">
            <label for="profile_picture" class="form-label">{{ __('Upload New Profile Picture') }}</label>
            <input type="file" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*">
            @error('profile_picture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
