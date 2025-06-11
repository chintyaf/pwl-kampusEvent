{{-- resources/views/protected/events.blade.php --}}
@extends('layouts.app')

@section('title', 'Events Management')

@section('content')
<div>
    <h1>Events Management</h1>
    <p>{{ $data['message'] }}</p>
    <p>Data: {{ $data['data'] }}</p>
    
    <a href="{{ route('dashboard') }}">← Back to Dashboard</a>
</div>
@endsection