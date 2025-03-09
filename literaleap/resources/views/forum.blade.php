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
    <div class="card mb-3" id="post-{{ $post->id }}">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->body }}</p>
            <div class="d-flex align-items-center">
                <!-- Like Button -->
                <button class="btn btn-link p-0 me-3" onclick="handleLike({{ $post->id }})">
                    <i id="like-icon-{{ $post->id }}" class="bi bi-hand-thumbs-up"
                        style="font-size: 1.5rem; color: black;"></i>
                    <span id="like-count-{{ $post->id }}">{{ $post->likes_count }}</span>
                </button>

                <!-- Dislike Button -->
                <button class="btn btn-link p-0" onclick="handleDislike({{ $post->id }})">
                    <i id="dislike-icon-{{ $post->id }}" class="bi bi-hand-thumbs-down"
                        style="font-size: 1.5rem; color: black;"></i>
                    <span id="dislike-count-{{ $post->id }}">{{ $post->dislikes_count }}</span>
                </button>
            </div>
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

function handleLike(postId) {
    let likeIcon = document.getElementById('like-icon-' + postId);
    let dislikeIcon = document.getElementById('dislike-icon-' + postId);
    let likeCount = document.getElementById('like-count-' + postId);
    let dislikeCount = document.getElementById('dislike-count-' + postId);

    // If already liked, then remove like
    if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
        fetch('/forum/' + postId + '/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    action: 'unlike'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeIcon.classList.remove('bi-hand-thumbs-up-fill');
                    likeIcon.classList.add('bi-hand-thumbs-up');
                    likeIcon.style.color = 'black';
                    likeCount.innerText = data.likes_count;
                }
            });
        return;
    }

    // If currently disliked, switch from dislike to like
    if (dislikeIcon.classList.contains('bi-hand-thumbs-down-fill')) {
        fetch('/forum/' + postId + '/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    action: 'switch_to_like'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update dislike to default
                    dislikeIcon.classList.remove('bi-hand-thumbs-down-fill');
                    dislikeIcon.classList.add('bi-hand-thumbs-down');
                    dislikeIcon.style.color = 'black';
                    // Update like to filled and green
                    likeIcon.classList.remove('bi-hand-thumbs-up');
                    likeIcon.classList.add('bi-hand-thumbs-up-fill');
                    likeIcon.style.color = 'green';
                    likeCount.innerText = data.likes_count;
                    dislikeCount.innerText = data.dislikes_count;
                }
            });
        return;
    }

    // Otherwise, add a like
    fetch('/forum/' + postId + '/like', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({
                action: 'like'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                likeIcon.classList.remove('bi-hand-thumbs-up');
                likeIcon.classList.add('bi-hand-thumbs-up-fill');
                likeIcon.style.color = 'green';
                likeCount.innerText = data.likes_count;
            }
        });
}

function handleDislike(postId) {
    let dislikeIcon = document.getElementById('dislike-icon-' + postId);
    let likeIcon = document.getElementById('like-icon-' + postId);
    let dislikeCount = document.getElementById('dislike-count-' + postId);
    let likeCount = document.getElementById('like-count-' + postId);

    // If already disliked, then remove dislike
    if (dislikeIcon.classList.contains('bi-hand-thumbs-down-fill')) {
        fetch('/forum/' + postId + '/dislike', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    action: 'undislike'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    dislikeIcon.classList.remove('bi-hand-thumbs-down-fill');
                    dislikeIcon.classList.add('bi-hand-thumbs-down');
                    dislikeIcon.style.color = 'black';
                    dislikeCount.innerText = data.dislikes_count;
                }
            });
        return;
    }

    // If currently liked, switch from like to dislike
    if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
        fetch('/forum/' + postId + '/dislike', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    action: 'switch_to_dislike'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeIcon.classList.remove('bi-hand-thumbs-up-fill');
                    likeIcon.classList.add('bi-hand-thumbs-up');
                    likeIcon.style.color = 'black';
                    dislikeIcon.classList.remove('bi-hand-thumbs-down');
                    dislikeIcon.classList.add('bi-hand-thumbs-down-fill');
                    dislikeIcon.style.color = 'red';
                    likeCount.innerText = data.likes_count;
                    dislikeCount.innerText = data.dislikes_count;
                }
            });
        return;
    }

    // Otherwise, add a dislike
    fetch('/forum/' + postId + '/dislike', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({
                action: 'dislike'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                dislikeIcon.classList.remove('bi-hand-thumbs-down');
                dislikeIcon.classList.add('bi-hand-thumbs-down-fill');
                dislikeIcon.style.color = 'red';
                dislikeCount.innerText = data.dislikes_count;
            }
        });
}
</script>
@endsection