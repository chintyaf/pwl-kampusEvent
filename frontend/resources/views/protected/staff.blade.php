{{-- resources/views/protected/staff.blade.php --}}
@extends('layouts.app')

@section('title', 'Staff Area')

@section('content')
<div>
    <h1>Staff Area</h1>
    <p>{{ $data['message'] }}</p>
    <p>Data: {{ $data['data'] }}</p>
    
    <a href="{{ route('dashboard') }}">← Back to Dashboard</a>
</div>
@endsection