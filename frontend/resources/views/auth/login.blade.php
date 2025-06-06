{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div>
    <h1>Login</h1>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    
    <p>
        Don't have an account? <a href="{{ route('register') }}">Register here</a>
    </p>
</div>
@endsection
