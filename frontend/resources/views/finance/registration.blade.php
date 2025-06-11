@extends('layouts.finance')

@section('content')
<div class="container">
  <h3 class="mb-4">Verifikasi Pembayaran Peserta</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama Peserta</th>
        <th>Email</th>
        <th>Event</th>
        <th>Status Pembayaran</th>
        <th>Bukti Bayar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @if (!empty($registrations))
    @foreach ($registrations as $reg)
      <tr>
        <td>{{ $reg['userId']['name'] ?? '-' }}</td>
        <td>{{ $reg['userId']['email'] ?? '-' }}</td>
        <td>{{ $reg['eventId']['title'] ?? '-' }}</td>
        <td>
          <span class="badge bg-{{ 
            $reg['paymentStatus'] === 'paid' ? 'success' : 
            ($reg['paymentStatus'] === 'pending' ? 'warning' : 
            ($reg['paymentStatus'] === 'rejected' ? 'danger' : 'secondary')) }}">
            {{ ucfirst($reg['paymentStatus']) }}
          </span>
        </td>
      </tr>
    @endforeach
  @else
    <tr>
      <td colspan="4">Tidak ada data registrasi.</td>
    </tr>
  @endif
    </tbody>
  </table>
</div>
@endsection
