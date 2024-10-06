@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Create Post</h1>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
                    @csrf
                    <div class="mb-3">
                        <x-label for="title" :value="__('Title')" class="form-label" />
                        <x-input id="title" class="form-control" type="text" name="title" required autofocus />
                    </div>
                
                    <div class="mb-3">
                        <x-label for="content" :value="__('Content')" class="form-label" />
                        <textarea id="content" class="form-control" name="content" rows="4" required></textarea>
                    </div>
                
                    <div class="mb-3">
                        <x-label for="picture" :value="__('Picture')" class="form-label" />
                        <input id="picture" class="form-control" type="file" name="picture" />
                    </div>
                
                    <div class="d-flex justify-content-end">
                        <x-button class="btn btn-primary">
                            {{ __('Submit') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
