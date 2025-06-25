@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome to the admin dashboard.</p>
        <ul>
            <li><a href="{{ route('admin.manage-users') }}">Manage Users</a></li>
            <li><a href="{{ route('admin.manage-events') }}">Manage Events</a></li>
        </ul>
    </div>
@endsection
