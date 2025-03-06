<section class="container p-4 bg-white shadow-sm rounded">
    <header class="mb-4">
        <h2 class="h4 fw-bold text-danger">{{ __('Delete Account') }}</h2>
        <p class="text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Delete Account Button -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        {{ __('Delete Account') }}
    </button>

    <!-- Confirm Deletion Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">{{ __('Are you sure?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <!-- Delete Account Form -->
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Enter your password') }}" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
