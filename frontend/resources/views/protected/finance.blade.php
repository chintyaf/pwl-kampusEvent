{{-- resources/views/protected/finance.blade.php --}}
@extends('layouts.app')

@section('title', 'Finance Section')

@section('content')
<div>
    <h1>Finance Section</h1>
    <p>{{ $data['message'] }}</p>
    <p>Data: {{ $data['data'] }}</p>
    
    <a href="{{ route('dashboard') }}">← Back to Dashboard</a>
</div>
@endsection