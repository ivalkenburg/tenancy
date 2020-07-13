@extends('layouts.app')

@section('title', "{$post->title} - Edit Post")

@section('content')
    <h1>{{ $post->title }}</h1>
    <form method="post" action="{{ route('posts.update', $post->id) }}">
        @csrf
        @method('put')
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ $post->title }}">
        </div>
        <div>
            <label for="body">Body</label>
            <textarea name="body" id="body" cols="30" rows="10">{{ $post->body }}</textarea>
        </div>
        <button type="submit">Edit Post</button>
    </form>
    <p>
        <a href="{{ route('posts.show', $post->id) }}">Go Back</a>
    </p>
@endsection
