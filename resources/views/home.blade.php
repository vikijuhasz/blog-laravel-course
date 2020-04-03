@extends('layout')

@section('content')
    <h1>{{ __('messages.welcome') }}</h1>
    <h1>@lang('messages.welcome')</h1>

    <p>{{ __('messages.example_with_value', ['name' => 'John']) }}</p>

    <p>{{ trans_choice('messages.comments', 0, ['a' => 1]) }}</p>

    <p>{{ trans_choice('messages.comments', 1, ['a' => 1]) }}</p>

    <p>{{ trans_choice('messages.comments', 2, ['a' => 1]) }}</p>

    <p>Using JSON: {{ __('Welcome to Laravel!') }}</p>
    <p>Using JSON: {{ __('Hello :name', ['name' => 'Viki']) }}</p>

    <p>This is the content of the main page.</p>
@endsection