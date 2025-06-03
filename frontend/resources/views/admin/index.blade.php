{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <h1>Ini Dashboard Admin</h1>
</body>
</html> --}}

@extends('layouts.admin')
@section('content')
<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
      <!-- Jumlah Semua Event -->
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Total Semua Event</h5>
            <h2 id="totalEvents">0</h2>
          </div>
        </div>
      </div>

      <!-- Jumlah Event Aktif -->
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Event Aktif</h5>
            <h2 id="activeEvents">0</h2>
          </div>
        </div>
      </div>

      <!-- Jumlah Request Event Baru -->
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Request Event Baru</h5>
            <h2 id="pendingEvents">0</h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabel Request Event Baru -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0">Daftar Request Event Baru</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama Event</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Pengaju</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="requestEventTable">
              <tr>
                <td colspan="5" class="text-center">Memuat data...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  {{-- </div> --}}

  {{-- <div class="container-xxl flex-grow-1 container-p-y"> --}}

    <div class="row">
      <!-- Card: Pertumbuhan Member -->
      <div class="col-12 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h5 class="card-title mb-3">Pertumbuhan Jumlah Member per Bulan</h5>
              <div class="dropdown">
                <button
                  class="btn p-0"
                  type="button"
                  id="dropdownGrowth"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownGrowth">
                  <a class="dropdown-item" href="#">Lihat Detail</a>
                </div>
              </div>
            </div>
            <canvas id="memberGrowthChart" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <a href="{{ route('admin.list-member') }}" class="stretched-link text-decoration-none text-dark">
            <div class="card-body text-center">
                <h5 class="card-title">Jumlah Member</h5>
                <h2 id="totalMembers">0</h2>
            </div>
            </a>
        </div>
    </div>

  </div>
</div>


@endsection