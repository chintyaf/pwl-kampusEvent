{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div>
        <h1>Register</h1>

        {{-- <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div>
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="guest">Guest</option>
                    <option value="member">Member</option>
                    <option value="staff">Staff</option>
                    <option value="event_committee">Event Committee</option>
                    <option value="finance_team">Finance Team</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <button type="submit">Register</button>
            </div>
        </form> --}}

                <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="Chintya" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="chin@gmail.com" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="12345678" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" value="12345678" required>
            </div>

            <div>
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="guest">Guest</option>
                    <option value="member">Member</option>
                    <option value="staff">Staff</option>
                    <option value="event_committee">Event Committee</option>
                    <option value="finance_team">Finance Team</option>
                    <option selected value="admin">Admin</option>
                </select>
            </div>

            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <button type="submit">Register</button>
            </div>
        </form>

        <p>
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </p>
    </div>
@endsection
