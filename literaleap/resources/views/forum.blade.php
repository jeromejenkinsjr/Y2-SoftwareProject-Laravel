@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Forum</h1>

    @if(in_array(auth()->user()->role, ['student', 'teacher', 'admin']))
    <div class="mb-4">
        <a href="{{ route('forum.create') }}" class="btn btn-primary">Create New Post</a>
    </div>
    @endif

    @foreach($posts as $post)
    @php
    // Assuming $post->reactions is eager loaded or you can use a helper method.
    $userReaction = $post->reactions->firstWhere('user_id', auth()->id());
    @endphp
    <div class="card mb-3" id="post-{{ $post->id }}">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->body }}</p>
            @if($post->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="img-fluid"
                    style="max-height: 300px; object-fit: contain;">
            </div>
            @endif
            <div class="d-flex align-items-center">
                <!-- Like Button -->
                <button class="btn btn-link p-0 me-3" onclick="handleLike({{ $post->id }})">
                    <i id="like-icon-{{ $post->id }}"
                        class="bi {{ $userReaction && $userReaction->reaction === 'like' ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"
                        style="font-size: 1.5rem; color: {{ $userReaction && $userReaction->reaction === 'like' ? 'green' : 'black' }};"></i>
                    <span id="like-count-{{ $post->id }}">{{ $post->likes_count }}</span>
                </button>

                <!-- Dislike Button -->
                <button class="btn btn-link p-0" onclick="handleDislike({{ $post->id }})">
                    <i id="dislike-icon-{{ $post->id }}"
                        class="bi {{ $userReaction && $userReaction->reaction === 'dislike' ? 'bi-hand-thumbs-down-fill' : 'bi-hand-thumbs-down' }}"
                        style="font-size: 1.5rem; color: {{ $userReaction && $userReaction->reaction === 'dislike' ? 'red' : 'black' }};"></i>
                    <span id="dislike-count-{{ $post->id }}">{{ $post->dislikes_count }}</span>
                </button>

            </div>
            @if(auth()->user()->id === $post->user_id || auth()->user()->role === 'admin')
            <!-- Delete Button -->
            <button type="button" class="btn btn-danger btn-sm ms-auto" data-bs-toggle="modal"
                data-bs-target="#deleteModal-{{ $post->id }}">
                Delete
            </button>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal-{{ $post->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel-{{ $post->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel-{{ $post->id }}">Confirm Delete</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the post titled "<strong>{{ $post->title }}</strong>"? This
                            action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('forum.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <div class="card-footer">
            <h6>Replies:</h6>
            @foreach($post->replies as $reply)
            <div class="mb-2">
                <strong>{{ $reply->user->name }}:</strong> {{ $reply->body }}
            </div>
            @endforeach

            @if(in_array(auth()->user()->role, ['student', 'teacher', 'admin']))
            <form action="{{ route('forum.reply', $post->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="mb-3">
                    <textarea name="reply" class="form-control" rows="2" placeholder="Write a reply..."></textarea>
                </div>
                <button type="submit" class="btn btn-secondary btn-sm">Reply</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>

<script>
// Helper function to get the CSRF token
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

function handleLike(postId) {
    let likeIcon = document.getElementById('like-icon-' + postId);
    let dislikeIcon = document.getElementById('dislike-icon-' + postId);
    let likeCount = document.getElementById('like-count-' + postId);
    let dislikeCount = document.getElementById('dislike-count-' + postId);

    fetch('/forum/' + postId + '/like', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({}) // no extra parameter needed
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Toggle like icon state
                if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
                    // If it was filled, then un-like it.
                    likeIcon.classList.remove('bi-hand-thumbs-up-fill');
                    likeIcon.classList.add('bi-hand-thumbs-up');
                    likeIcon.style.color = 'black';
                } else {
                    // Fill the like icon
                    likeIcon.classList.remove('bi-hand-thumbs-up');
                    likeIcon.classList.add('bi-hand-thumbs-up-fill');
                    likeIcon.style.color = 'green';
                }
                // Only reset the dislike icon if it was previously filled.
                if (dislikeIcon.classList.contains('bi-hand-thumbs-down-fill')) {
                    dislikeIcon.classList.remove('bi-hand-thumbs-down-fill');
                    dislikeIcon.classList.add('bi-hand-thumbs-down');
                    dislikeIcon.style.color = 'black';
                }
                // Update counts from server response
                likeCount.innerText = data.likes_count;
                dislikeCount.innerText = data.dislikes_count;
            }
        });
}

function handleDislike(postId) {
    let dislikeIcon = document.getElementById('dislike-icon-' + postId);
    let likeIcon = document.getElementById('like-icon-' + postId);
    let dislikeCount = document.getElementById('dislike-count-' + postId);
    let likeCount = document.getElementById('like-count-' + postId);

    fetch('/forum/' + postId + '/dislike', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({}) // no extra parameter needed
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Toggle dislike icon state
                if (dislikeIcon.classList.contains('bi-hand-thumbs-down-fill')) {
                    // If it was filled, then un-dislike it.
                    dislikeIcon.classList.remove('bi-hand-thumbs-down-fill');
                    dislikeIcon.classList.add('bi-hand-thumbs-down');
                    dislikeIcon.style.color = 'black';
                } else {
                    // Fill the dislike icon
                    dislikeIcon.classList.remove('bi-hand-thumbs-down');
                    dislikeIcon.classList.add('bi-hand-thumbs-down-fill');
                    dislikeIcon.style.color = 'red';
                }
                // Only reset the like icon if it was previously filled.
                if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
                    likeIcon.classList.remove('bi-hand-thumbs-up-fill');
                    likeIcon.classList.add('bi-hand-thumbs-up');
                    likeIcon.style.color = 'black';
                }
                // Update counts from server response
                likeCount.innerText = data.likes_count;
                dislikeCount.innerText = data.dislikes_count;
            }
        });
}
</script>
@endsection