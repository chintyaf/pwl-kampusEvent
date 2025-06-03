@extends('layouts.finance') <!-- Ubah sesuai layout kamu -->

@section('content')
<div class="container mt-4">
  <h4 class="fw-bold">Dashboard Tim Keuangan</h4>

  <!-- Tabel Pembayaran Belum Dikonfirmasi -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-white">Pembayaran Belum Dikonfirmasi</div>
    <div class="card-body table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nama Peserta</th>
            <th>Event</th>
            <th>Jumlah</th>
            <th>Bukti</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($unverifiedPayments as $payment)
          <tr>
            <td>{{ $payment->user->name }}</td>
            <td>{{ $payment->event->title }}</td>
            <td>Rp{{ number_format($payment->amount) }}</td>
            <td>
              <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
            </td>
            <td>{{ $payment->created_at->format('d M Y') }}</td>
            <td>
              <form method="POST" action="{{ route('finance.approve', $payment->id) }}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6">Tidak ada pembayaran yang menunggu verifikasi.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Tabel Pembayaran Sudah Dikonfirmasi -->
  <div class="card">
    <div class="card-header bg-success text-white">Pembayaran Terkonfirmasi</div>
    <div class="card-body table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nama Peserta</th>
            <th>Event</th>
            <th>Jumlah</th>
            <th>Bukti</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($verifiedPayments as $payment)
          <tr>
            <td>{{ $payment->user->name }}</td>
            <td>{{ $payment->event->title }}</td>
            <td>Rp{{ number_format($payment->amount) }}</td>
            <td>
              <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
            </td>
            <td>{{ $payment->updated_at->format('d M Y') }}</td>
          </tr>
          @empty
          <tr><td colspan="5">Belum ada pembayaran yang dikonfirmasi.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
