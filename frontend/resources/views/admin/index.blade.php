{{-- resources/views/admin/index.blade.php --}}
@extends('layouts.back')

@section('title', 'Dashboard Admin')

@section('content')
    <br>

    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard Administrator</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row">
            {{-- Total Users Card --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <span class="text-muted">Total Users</span>
                                <h3 class="mb-0">{{ $statistics['total_users'] ?? 0 }}</h3>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-users font-size-20"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            {{-- Total Events Card --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <span class="text-muted">Total Events</span>
                                <h3 class="mb-0">{{ $statistics['total_events'] ?? 0 }}</h3>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                <span class="avatar-title">
                                    <i class="bx bx-calendar-event font-size-20"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Registrations Card --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <span class="text-muted">Total Registrations</span>
                                <h3 class="mb-0">{{ $statistics['total_registrations'] ?? 0 }}</h3>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                <span class="avatar-title">
                                    <i class="bx bx-check-circle font-size-20"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Payments Card --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <span class="text-muted">Pending Payments</span>
                                <h3 class="mb-0">{{ $statistics['pending_payments'] ?? 0 }}</h3>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                <span class="avatar-title">
                                    <i class="bx bx-time font-size-20"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        {{-- Quick Actions --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('admin.manage-users') }}" class="btn btn-primary btn-lg w-100">
                                    <i class="bx bx-users me-2"></i>
                                    Kelola Pengguna
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#createFinanceModal">
                                    <i class="bx bx-user-plus me-2"></i>
                                    Buat Akun Tim Keuangan
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="button" class="btn btn-info btn-lg w-100" data-bs-toggle="modal" data-bs-target="#createCommitteeModal">
                                    <i class="bx bx-user-plus me-2"></i>
                                    Buat Akun Panitia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk membuat akun Tim Keuangan --}}
    <div class="modal fade" id="createFinanceModal" tabindex="-1" aria-labelledby="createFinanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.create-finance') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createFinanceModalLabel">Buat Akun Tim Keuangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="finance_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="finance_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="finance_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="finance_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="finance_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="finance_password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="finance_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="finance_password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Buat Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal untuk membuat akun Panitia Kegiatan --}}
    <div class="modal fade" id="createCommitteeModal" tabindex="-1" aria-labelledby="createCommitteeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.create-committee') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCommitteeModalLabel">Buat Akun Panitia Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="committee_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="committee_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="committee_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="committee_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="committee_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="committee_password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="committee_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="committee_password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Buat Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

@endsection

{{-- Custom JavaScript untuk dashboard --}}
@section('scripts')
    <script>
        // Auto-refresh statistics setiap 30 detik
        setInterval(function() {
            // AJAX call untuk refresh statistik tanpa reload halaman
            fetch('/admin/api/statistics')
                .then(response => response.json())
                .then(data => {
                    // Update nilai statistik di card
                    document.querySelector('.total-users').textContent = data.total_users;
                    document.querySelector('.total-events').textContent = data.total_events;
                    document.querySelector('.total-registrations').textContent = data.total_registrations;
                    document.querySelector('.pending-payments').textContent = data.pending_payments;
                })
                .catch(error => console.log('Error refreshing statistics:', error));
        }, 30000); // 30 detik
    </script>
@endsection
