@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Post</h1>
    <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image (Max: 2MB)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="wrapText('bold')">Bold</button>
            <button type="button" class="btn btn-secondary" onclick="wrapText('italic')">Italic</button>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('body');

    function wrapText(tag) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        const newText = tag === 'bold' ? `**${selectedText}**` : `*${selectedText}*`;
        textarea.setRangeText(newText, start, end, 'end');
    }

    window.wrapText = wrapText;
});
</script>
@endsection