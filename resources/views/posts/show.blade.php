@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->body }}</p>
    @if($post->author)
        Written by {{ $post->author->name }}
    @endif
    <hr>
    <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
    <form style="display: inline;" id="delete" method="post" action="{{ route('posts.destroy', $post->id) }}">
        @csrf
        @method('delete')
        <a href="#" onclick="document.getElementById('delete').submit()">Delete</a>
    </form>
    <a href="{{ route('posts.index') }}">Posts</a>
    <a href="{{ route('home') }}">Home</a>
@endsection
