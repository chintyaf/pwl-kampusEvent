{{-- resources/views/admin/index.blade.php --}}
@extends('layouts.back')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- <br> --}}

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
                            {{-- <div class="col-md-4 mb-3">
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
                            </div> --}}
                            <div class="col-md-4 mb-3">
                                <button class="btn btn-success w-100 btn-lg" data-bs-toggle="modal" data-bs-target="#createUserModal">Tambah Akun Tim</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Akun Panitia/Finance -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/register" id="createTeamForm" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="createUserModalLabel">Buat Akun Tim</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Peran</label>
                <select name="role" class="form-select" required>
                    <option value="">Pilih Role</option>
                    <option value="event_committee">Panitia</option>
                    <option value="finance_team">Tim Keuangan</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Buat Akun</button>
        </div>
    </form>
  </div>
</div>

<!-- Tombol di Halaman Admin -->


    {{-- Modal untuk membuat akun Tim Keuangan --}}
    {{-- <div class="modal fade" id="createFinanceModal" tabindex="-1" aria-labelledby="createFinanceModalLabel" aria-hidden="true">
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
    </div> --}}

    {{-- Modal untuk membuat akun Panitia Kegiatan --}}
    {{-- <div class="modal fade" id="createCommitteeModal" tabindex="-1" aria-labelledby="createCommitteeModalLabel" aria-hidden="true">
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
    </div> --}}

    {{-- Success/Error Messages --}}
    {{-- @if(session('success'))
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
    @endif --}}

@endsection

{{-- Custom JavaScript untuk dashboard --}}
@section('scripts')

        <script>
document.getElementById("createTeamForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch("/admin/register-team", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert("Berhasil buat akun!");
        // Optional: close modal, refresh data, dll
    })
    .catch(err => {
        alert("Gagal membuat akun.");
    });
});
</script>
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
