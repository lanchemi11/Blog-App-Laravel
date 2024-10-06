@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12">
            <h1 class="mt-5">Edit Post</h1>

            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title" class="pb-2">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $post->title) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label for="content" class="pb-2">Content</label>
                    <textarea class="form-control" name="content" id="content" rows="5" required>{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="form-group mt-3">
                    <label for="picture">Post Image</label>
                    <input type="file" class="form-control" name="picture" id="picture" accept="image/*">
                    @if ($post->picture)
                        <img src="{{ asset('storage/' . $post->picture) }}" alt="Current Image" class="img-fluid rounded mt-2" style="max-height: 200px;">
                        <p>Current Image: <a href="{{ asset('storage/' . $post->picture) }}" target="_blank">View</a></p>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Update Post</button>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
