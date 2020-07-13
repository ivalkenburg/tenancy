@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <h1>Posts</h1>
    <p>
        <a href="{{ route('posts.create') }}">Create Post</a>
    </p>
    <ul>
        @foreach($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
    <p>
        <a href="{{ route('home') }}">Home</a>
    </p>
@endsection
