@extends('layouts.finance')

@section('content')
<div class="container mx-auto p-4">
  <!-- Dashboard Ringkasan -->
  @if(isset($paidCount) && isset($unpaidCount))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="text-xl font-semibold mb-2">Peserta Sudah Bayar</h2>
            <p class="text-4xl text-green-600 font-bold">{{ $paidCount }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="text-xl font-semibold mb-2">Peserta Belum Bayar</h2>
            <p class="text-4xl text-red-500 font-bold">{{ $unpaidCount }}</p>
        </div>
    </div>
@endif
</div>


  <!-- Filter Event -->
  <form method="GET" action="{{ route('finance.index') }}" class="mb-4">
    <label for="event" class="block mb-1 font-medium">Pilih Event</label>
    <select id="event" name="event_id" class="w-full p-2 border rounded">
      @foreach($events as $event)
        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
          {{ $event->name }} - {{ $event->date }}
        </option>
      @endforeach
    </select>
    <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
  </form>

  <!-- Tabel Pembayaran -->
  <div class="bg-white rounded-2xl shadow overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left">Nama</th>
          <th class="px-4 py-2 text-left">Email</th>
          <th class="px-4 py-2 text-left">Status Pembayaran</th>
          <th class="px-4 py-2 text-left">Bukti</th>
          <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($participants as $user)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $user->name }}</td>
          <td class="px-4 py-2">{{ $user->email }}</td>
          <td class="px-4 py-2">
            @if($user->paid)
              <span class="text-green-600 font-semibold">Sudah Bayar</span>
            @else
              <span class="text-red-500 font-semibold">Belum Bayar</span>
            @endif
          </td>
          <td class="px-4 py-2">
            @if($user->payment_proof_url)
              <a href="{{ asset('storage/' . $user->payment_proof_url) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti</a>
            @else
              -
            @endif
          </td>
          <td class="px-4 py-2">
            <form method="POST" action="{{ route('finance.updatePayment', $user->id) }}">
              @csrf
              @method('PUT')
              <select name="paid" class="p-1 border rounded">
                <option value="1" {{ $user->paid ? 'selected' : '' }}>Sudah Bayar</option>
                <option value="0" {{ !$user->paid ? 'selected' : '' }}>Belum Bayar</option>
              </select>
              <button type="submit" class="ml-2 px-2 py-1 bg-green-600 text-white rounded">Update</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
