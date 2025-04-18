<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile Update</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CropperJS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container py-5">
        @if (auth()->user()->onTrial('default'))
        <div class="alert alert-info">
            Your free trial ends on {{ auth()->user()->subscription('default')->trial_ends_at->format('F j, Y') }}.
        </div>
        @endif

        @php
        // Define XP thresholds for levels (adjust as needed)
        $thresholds = [0, 10, 25, 50, 100, 200, 500, 1000];
        $currentLevel = auth()->user()->level;
        $currentXP = auth()->user()->xp;
        // Calculate minimum XP for current level and XP needed for next level
        $minXP = $thresholds[$currentLevel - 1] ?? 0;
        $maxXP = $thresholds[$currentLevel] ?? $currentXP;
        $xpForLevel = $maxXP - $minXP;
        $xpProgress = $currentXP - $minXP;
        $progressPercent = $xpForLevel > 0 ? ($xpProgress / $xpForLevel) * 100 : 100;
        @endphp

        <div class="mb-3 row">
            <label for="xp-progress" class="col-sm-2 col-form-label">Experience (XP)</label>
            <div class="col-sm-8">
                <div class="progress">
                    <div class="progress-bar" role="progressbar"
                        style="width: {{ $progressPercent }}% ; background-color: orange;"
                        aria-valuenow="{{ $xpProgress }}" aria-valuemin="{{ $minXP }}" aria-valuemax="{{ $maxXP }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-2 text-end">
                <span>{{ auth()->user()->xp }} XP</span>
            </div>
        </div>

        <div class="mb-3">
            <p class="mb-0"><strong>Level: {{ auth()->user()->level }}</strong></p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile Information Card -->
                <div class="card">
                    <div class="card-body">
                        <section class="p-4">
                            <header class="mb-4">
                                <h2 class="h4 fw-bold text-primary">Profile Information</h2>
                                <p class="text-muted">Update your account's profile information and email address.</p>
                            </header>

                            <!-- Display Success Message -->
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif

                            <!-- Profile Picture Upload Form -->
                            <form method="POST" action="{{ url('/profile/update-picture') }}"
                                enctype="multipart/form-data" class="mb-4">
                                @csrf
                                <div class="mb-3 text-center">
                                    @php
                                    $profilePicture = Auth::user()->profile_picture;
                                    if ($profilePicture) {
                                    $profilePictureUrl = \Illuminate\Support\Str::startsWith($profilePicture, 'images/')
                                    ? asset($profilePicture)
                                    : asset('storage/' . $profilePicture);
                                    } else {
                                    $profilePictureUrl = asset('images/defaultava.jpg');
                                    }
                                    @endphp
                                    <img src="{{ $profilePictureUrl }}" alt="Profile Picture"
                                        class="rounded-circle img-thumbnail shadow"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>

                                <!-- Upload New Profile Picture -->
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Upload New Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control"
                                        accept="image/*">
                                </div>

                                <!-- Hidden fields for cropping coordinates -->
                                <input type="hidden" name="crop_x" id="crop_x">
                                <input type="hidden" name="crop_y" id="crop_y">
                                <input type="hidden" name="crop_width" id="crop_width">
                                <input type="hidden" name="crop_height" id="crop_height">

                                <!-- Purchased Shop Items Section -->
                                <div class="mb-3">
                                    <p class="text-muted">Or select one of your purchased shop items as your profile
                                        picture</p>
                                    <div class="row">
                                        @foreach(auth()->user()->shopItems->where('type', 'item') as $shopItem)
                                        @php
                                        $extension = strtolower(pathinfo($shopItem->image, PATHINFO_EXTENSION));
                                        @endphp
                                        @if(in_array($extension, ['gif', 'png', 'avif', 'jpeg', 'jpg']))
                                        <div class="col-4 mb-2">
                                            <div class="card shop-item-selection d-flex align-items-center justify-content-center p-3"
                                                data-shop-item-id="{{ $shopItem->id }}"
                                                style="cursor: pointer; height: 100%;">
                                                <img src="{{ asset($shopItem->image) }}"
                                                    class="rounded-circle img-thumbnail shadow"
                                                    alt="{{ $shopItem->name }}"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="shop_item_id" id="shop_item_id" value="">
                                </div>

                                <!-- Optional Cropper Container -->
                                <div id="crop-container" style="display: none; margin-bottom: 1rem;">
                                    <h5>Adjust your crop selection</h5>
                                    <img id="crop-image" style="max-width: 100%;" alt="Crop Preview">
                                    <button type="button" id="crop-btn" class="btn btn-secondary mt-2">Crop
                                        Image</button>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Update Profile Picture</button>
                            </form>
                            <!-- End of Profile Picture Upload Form -->

                            <!-- User's Icons Preview -->
                            <div class="mb-4 text-center">
                                <h5 class="text-primary">Profile Icon Preview</h5>
                                @php
                                $userIcons = auth()->user()->shopItems->where('type', 'icon');
                                $selectedIcon = auth()->user()->profile_icon
                                ? $userIcons->where('image', auth()->user()->profile_icon)->first()
                                : null;
                                $selectedIconUrl = $selectedIcon ? asset($selectedIcon->image) :
                                asset('images/default-icon.png');
                                @endphp

                                <!-- Display the user's name with the selected icon to its right -->
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="fs-5 me-1">{{ auth()->user()->name }}</span>
                                    <img id="selected-icon" src="{{ $selectedIconUrl }}" alt="User Icon"
                                        class="rounded-circle" style="width: 20px; height: 20px; object-fit: cover;">
                                </div>
                                <p id="selected-icon-name" class="mt-2">
                                    {{ $selectedIcon ? $selectedIcon->name : 'No Icon Selected' }}
                                </p>

                                <!-- Icon Selection Form -->
                                @if($userIcons->count() > 0)
                                <form method="POST" action="{{ route('profile.updateIcon') }}">
                                    @csrf
                                    <input type="hidden" name="selected_icon_id" id="selected_icon_id"
                                        value="{{ $selectedIcon ? $selectedIcon->id : '' }}">

                                    <div class="row justify-content-center">
                                        @foreach($userIcons as $icon)
                                        <div class="col-3 mb-2">
                                            <div class="card icon-selection d-flex align-items-center justify-content-center p-2"
                                                data-icon-id="{{ $icon->id }}" data-icon-name="{{ $icon->name }}"
                                                data-icon-url="{{ asset($icon->image) }}" style="cursor: pointer;">
                                                <img src="{{ asset($icon->image) }}" class="rounded-circle"
                                                    alt="{{ $icon->name }}"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Set as Profile Icon</button>
                                </form>
                                @else
                                <p class="text-muted">You haven't purchased any icons yet.</p>
                                @endif
                            </div>


                            <!-- Profile Information Update Form -->
                            <form method="POST" action="{{ url('/profile/update') }}" class="p-4 rounded">
                                @csrf
                                @method('PATCH')
                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}" required autofocus>
                                </div>
                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                                <!-- Save Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success px-4">Save Changes</button>
                                </div>
                            </form>
                            <!-- End of Profile Information Update Form -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CropperJS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let cropper;
        const fileInput = document.getElementById('profile_picture');
        const cropContainer = document.getElementById('crop-container');
        const cropImage = document.getElementById('crop-image');
        const cropBtn = document.getElementById('crop-btn');

        fileInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    cropImage.src = event.target.result;
                    cropContainer.style.display = 'block';
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(cropImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        movable: true,
                        zoomable: true,
                        rotatable: false,
                        scalable: false,
                    });
                }
                reader.readAsDataURL(file);
            }
        });

        cropBtn.addEventListener('click', function() {
            if (cropper) {
                const data = cropper.getData(true);
                document.getElementById('crop_x').value = data.x;
                document.getElementById('crop_y').value = data.y;
                document.getElementById('crop_width').value = data.width;
                document.getElementById('crop_height').value = data.height;
                cropContainer.style.display = 'none';
            }
        });

        // Handle shop item selection.
        document.querySelectorAll('.shop-item-selection').forEach(function(card) {
            card.addEventListener('click', function() {
                // Toggle selection on click.
                if (card.classList.contains('border') && card.classList.contains(
                        'border-primary')) {
                    // Unselect it.
                    card.classList.remove('border', 'border-primary');
                    document.getElementById('shop_item_id').value = "";
                } else {
                    // Unselect all other shop items.
                    document.querySelectorAll('.shop-item-selection').forEach(function(c) {
                        c.classList.remove('border', 'border-primary');
                    });
                    // Select the clicked card.
                    card.classList.add('border', 'border-primary');
                    document.getElementById('shop_item_id').value = card.getAttribute(
                        'data-shop-item-id');
                }
                // Clear file input and crop data when toggling shop items.
                fileInput.value = "";
                document.getElementById('crop_x').value = "";
                document.getElementById('crop_y').value = "";
                document.getElementById('crop_width').value = "";
                document.getElementById('crop_height').value = "";
            });
        });
    });
    </script>
    <script>
    document.querySelectorAll('.icon-selection').forEach(function(card) {
        card.addEventListener('click', function() {
            let iconId = card.getAttribute('data-icon-id');
            let iconName = card.getAttribute('data-icon-name');
            let iconUrl = card.getAttribute('data-icon-url');

            // Update the currently selected icon display
            document.getElementById('selected-icon').src = iconUrl;
            document.getElementById('selected-icon-name').textContent = iconName;
            document.getElementById('selected_icon_id').value = iconId;

            // Highlight the selected icon
            document.querySelectorAll('.icon-selection').forEach(function(c) {
                c.classList.remove('border', 'border-primary');
            });
            card.classList.add('border', 'border-primary');
        });
    });
    </script>
    <script>
    document.querySelectorAll('.icon-selection').forEach(function(card) {
        card.addEventListener('click', function() {
            let iconId = card.getAttribute('data-icon-id');
            let iconName = card.getAttribute('data-icon-name');
            let iconUrl = card.getAttribute('data-icon-url');

            // Update the currently selected icon display
            document.getElementById('selected-icon').src = iconUrl;
            document.getElementById('selected-icon-name').textContent = iconName;
            document.getElementById('selected_icon_id').value = iconId;

            // Highlight the selected icon
            document.querySelectorAll('.icon-selection').forEach(function(c) {
                c.classList.remove('border', 'border-primary');
            });
            card.classList.add('border', 'border-primary');
        });
    });
    </script>
</body>

</html>