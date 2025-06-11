{{-- resources/views/protected/admin.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div>
    <h1>Admin Panel</h1>
    <p>{{ $data['message'] }}</p>
    <p>Data: {{ $data['data'] }}</p>
    
    <a href="{{ route('dashboard') }}">← Back to Dashboard</a>
</div>
@endsection