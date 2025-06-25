@extends('layouts.back')

@section('title', 'Dashboard Tim Keuangan')

@section('content')
    <div class="container">
        <h2>Dashboard Tim Keuangan</h2>
        <p>Selamat datang di dashboard tim keuangan.</p>
        <a href="{{ route('finance.registrations') }}" class="btn btn-primary">Lihat Pembayaran</a>
    </div>
@endsection

