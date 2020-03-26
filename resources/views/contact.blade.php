@extends('layout')

@section('content')
    <h1>Contact</h1>
    <p>This is the contact page.</p>
    
    @can('home.secret')
        <a href="{{ route('secret') }}">
            Go to special contact details!
        </a>
    @endcan
@endsection
