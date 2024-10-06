@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-center justify-content-center mt-3">
        <div class="col-lg-6 col-md-12 rounded" style="background-color: #f8f9fa;">
            <h1>{{ $post->title }}</h1>

            @if ($post->picture)
                <img src="http://localhost:8000/storage/{{ $post->picture }}" alt="Post Image" class="img-fluid rounded mb-3" style="max-height: 200px;">
            @else
                <p>No image available for this post.</p>
            @endif

            <p>{{ $post->content }}</p>

            <h3>Comments:</h3>
            <ul class="list-group">
                @foreach($post->comments as $comment)
                    <li class="list-group-item">
                        <strong>{{ $comment->user ? $comment->user->name : 'Guest' }}:</strong>
                        {{ $comment->content }}
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary mt-2">Edit Post</a>
        </div>
    </div>
</div>
@endsection
