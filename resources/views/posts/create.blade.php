@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <h1>Create Post</h1>
    <form method="post" action="{{ route('posts.store') }}">
        @csrf
        <div>
            <label for="title">Title</label>
            <input id="title" type="text" name="title">
        </div>
        <div>
            <label for="body">Body</label>
            <textarea name="body" id="body" cols="30" rows="10"></textarea>
        </div>
        <button type="submit">Post</button>
    </form>
    <p>
        <a href="{{ route('posts.index') }}">Posts</a>
    </p>
@endsection
