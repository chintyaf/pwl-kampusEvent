{{-- resources/views/protected/members.blade.php --}}
@extends('layouts.app')

@section('title', 'Members Area')

@section('content')
<div>
    <h1>Members Area</h1>
    <p>{{ $data['message'] }}</p>
    <p>Data: {{ $data['data'] }}</p>
    
    <a href="{{ route('dashboard') }}">← Back to Dashboard</a>
</div>
@endsection