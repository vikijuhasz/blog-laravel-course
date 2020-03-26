@extends('layout')
@section('content')
    <form method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
       
        @include('posts._form')
        
        <button class="btn btn-primary btn-block">Update!</button>
    </form>
@endsection

