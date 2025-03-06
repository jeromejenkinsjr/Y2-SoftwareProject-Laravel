<section class="container p-4 bg-white shadow-sm rounded">
    <header class="mb-4">
        <h2 class="h4 fw-bold text-primary">{{ __('Update Password') }}</h2>
        <p class="text-muted">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input type="password" id="update_password_current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input type="password" id="update_password_password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Save Button & Success Message -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-success">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="text-success small mb-0 fade-in">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
