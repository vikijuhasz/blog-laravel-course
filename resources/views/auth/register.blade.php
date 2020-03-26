@extends('layout')
@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="form-group">
        <label>Name</label>
        <input name="name" value="{{ old('name') }}" required 
               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
        
         @if ($errors->has('name'))
            <span>
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
    
    <div class="form-group">
        <label>E-mail</label>
        <input name="email" value="{{ old('name') }}" required 
               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
        
        @if ($errors->has('email'))
            <span>
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required 
               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
        
         @if ($errors->has('password'))
            <span>
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required class="form-control">
    </div>
    
    <button type="submit" class="btn btn-primary btn-block">Register!</button>
    
</form>

<!-- we call the password_confirmation field this way because we have a confirmed validator. When you have a field that has this confirmed validation, you need to add another field, which has to be called the name of the field + _confirmation. -->
@endsection
