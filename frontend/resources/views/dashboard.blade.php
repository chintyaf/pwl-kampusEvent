{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1>Dashboard</h1>
    <p>Welcome, {{ $user['name'] }}!</p>
    <p>Your role: <strong>{{ $user['role'] }}</strong></p>
    
    <h2>Available Sections</h2>
    <ul>
        @if(in_array($user['role'], ['member', 'admin', 'staff']))
            <li><a href="{{ route('members') }}">Members Area</a></li>
        @endif
        
        @if(in_array($user['role'], ['staff', 'admin', 'finance_team', 'event_committee']))
            <li><a href="{{ route('staff') }}">Staff Area</a></li>
        @endif
        
        @if(in_array($user['role'], ['event_committee', 'admin']))
            <li><a href="{{ route('events') }}">Events Management</a></li>
        @endif
        
        @if(in_array($user['role'], ['finance_team', 'admin']))
            <li><a href="{{ route('finance') }}">Finance Section</a></li>
        @endif
        
        @if($user['role'] === 'admin')
            <li><a href="{{ route('admin') }}">Admin Panel</a></li>
        @endif
    </ul>
</div>
@endsection
