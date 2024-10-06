@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Posts</h1>
        
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="posts-list">
            <Post :auth-user="{{ Auth::user() ? Auth::user() : 'null' }}" :posts="{{ json_encode($posts) }}" />
        </div>
    </div>
@endsection
