{{-- resources/views/admin/manage-users.blade.php --}}
@extends('layouts.back')

@section('title', 'Kelola Pengguna')

@section('content')
    <br>
    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Kelola Pengguna</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                            <li class="breadcrumb-item active">Kelola Pengguna</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <br>

        {{-- Statistics Cards --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title text-muted mb-0">Total Member</h5>
                                <h3 class="mb-3" id="totalMembers">{{ $statistics['total_members'] ?? 0 }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bx bx-user text-primary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title text-muted mb-0">Tim Keuangan</h5>
                                <h3 class="mb-3" id="totalFinance">{{ $statistics['total_finance'] ?? 0 }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bx bx-money text-success" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title text-muted mb-0">Panitia Kegiatan</h5>
                                <h3 class="mb-3" id="totalCommittee">{{ $statistics['total_committee'] ?? 0 }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bx bx-group text-warning" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title text-muted mb-0">User Aktif</h5>
                                <h3 class="mb-3" id="totalActive">{{ $statistics['total_active'] ?? 0 }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bx bx-check-circle text-info" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        {{-- Filter Section --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Filter Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-3">
                                <label for="roleFilter" class="form-label">Role</label>
                                <select class="form-select" id="roleFilter" name="role">
                                    <option value="">Semua Role</option>
                                    <option value="member">Member</option>
                                    <option value="finance_team">Tim Keuangan</option>
                                    <option value="event_committee">Panitia Kegiatan</option>
                                    <option value="admin">Administrator</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="statusFilter" class="form-label">Status</label>
                                <select class="form-select" id="statusFilter" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="searchFilter" class="form-label">Cari</label>
                                <input type="text" class="form-control" id="searchFilter" name="search" placeholder="Nama atau Email">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>

        {{-- Users Table --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Pengguna</h4>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" id="createUserDropdown" data-bs-toggle="dropdown">
                                <i class="bx bx-plus me-1"></i> Buat Akun Baru
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="createUserDropdown">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createFinanceModal">
                                        <i class="bx bx-money me-1"></i> Tim Keuangan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createCommitteeModal">
                                        <i class="bx bx-group me-1"></i> Panitia Kegiatan
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="usersTable">
                                <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm rounded-circle bg-primary me-2">
                                                <span class="avatar-title text-white">
                                                    {{ substr($user['name'], 0, 1) }}
                                                </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user['name'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>
                                            @switch($user['role'])
                                                @case('member')
                                                    <span class="badge bg-info">Member</span>
                                                    @break
                                                @case('finance_team')
                                                    <span class="badge bg-success">Tim Keuangan</span>
                                                    @break
                                                @case('event_committee')
                                                    <span class="badge bg-warning">Panitia Kegiatan</span>
                                                    @break
                                                @case('admin')
                                                    <span class="badge bg-danger">Administrator</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $user['role'] }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle"
                                                       type="checkbox"
                                                       id="status{{ $user['_id'] }}"
                                                       data-user-id="{{ $user['_id'] }}"
                                                    {{ $user['status'] === 'active' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status{{ $user['_id'] }}">
                                                    {{ $user['status'] === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($user['created_at'])) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="viewUserDetail('{{ $user['_id'] }}')"
                                                        title="Detail">
                                                    <i class="bx bx-show"></i>
                                                </button>
                                                @if($user['role'] !== 'admin')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="deleteUser('{{ $user['_id'] }}', '{{ $user['name'] }}')"
                                                            title="Hapus">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pengguna</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create Finance User --}}
    <div class="modal fade" id="createFinanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Akun Tim Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createFinanceForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="financeName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="financeName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="financeEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="financeEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="financePassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="financePassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="financePasswordConfirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="financePasswordConfirmation" name="password_confirmation" required>
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

    {{-- Modal Create Committee User --}}
    <div class="modal fade" id="createCommitteeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Akun Panitia Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createCommitteeForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="committeeName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="committeeName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="committeeEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="committeeEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="committeePassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="committeePassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="committeePasswordConfirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="committeePasswordConfirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Buat Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal User Detail --}}
    <div class="modal fade" id="userDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="userDetailContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#usersTable').DataTable({
                "pageLength": 10,
                "searching": false, // Disable default search since we have custom filter
                "ordering": true,
                "info": true,
                "paging": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });

            // Custom filter function
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                filterUsers();
            });

            // Status toggle handler
            $('.status-toggle').on('change', function() {
                const userId = $(this).data('user-id');
                const isActive = $(this).is(':checked');
                const status = isActive ? 'active' : 'inactive';

                updateUserStatus(userId, status, $(this));
            });

            // Create Finance User Form
            $('#createFinanceForm').on('submit', function(e) {
                e.preventDefault();
                createUser('finance', $(this));
            });

            // Create Committee User Form
            $('#createCommitteeForm').on('submit', function(e) {
                e.preventDefault();
                createUser('committee', $(this));
            });
        });

        /**
         * Filter users based on form inputs
         * Mengirim request AJAX untuk memfilter data pengguna
         */
        function filterUsers() {
            const formData = {
                role: $('#roleFilter').val(),
                status: $('#statusFilter').val(),
                search: $('#searchFilter').val()
            };

            $.ajax({
                url: '{{ route("admin.manage-users") }}',
                method: 'GET',
                data: formData,
                success: function(response) {
                    // Reload page with filtered data
                    window.location.href = '{{ route("admin.manage-users") }}?' + $.param(formData);
                },
                error: function(xhr) {
                    console.error('Filter error:', xhr);
                }
            });
        }

        /**
         * Update user status (active/inactive)
         * @param {string} userId - ID pengguna
         * @param {string} status - Status baru (active/inactive)
         * @param {jQuery} toggleElement - Element toggle switch
         */
        function updateUserStatus(userId, status, toggleElement) {
            $.ajax({
                url: `/admin/users/${userId}/status`,
                method: 'PUT',
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update label
                        const label = toggleElement.siblings('label');
                        label.text(status === 'active' ? 'Aktif' : 'Tidak Aktif');

                        // Update statistics
                        updateStatistics();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status pengguna berhasil diperbarui',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    // Revert toggle
                    toggleElement.prop('checked', !toggleElement.prop('checked'));

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memperbarui status pengguna'
                    });
                }
            });
        }

        /**
         * Create new user (finance or committee)
         * @param {string} type - Tipe pengguna (finance/committee)
         * @param {jQuery} formElement - Form element
         */
        function createUser(type, formElement) {
            const formData = formElement.serialize();
            const url = type === 'finance' ? '{{ route("admin.create-finance") }}' : '{{ route("admin.create-committee") }}';

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Close modal
                        const modalId = type === 'finance' ? '#createFinanceModal' : '#createCommitteeModal';
                        $(modalId).modal('hide');

                        // Reset form
                        formElement[0].reset();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: `Akun ${type === 'finance' ? 'Tim Keuangan' : 'Panitia Kegiatan'} berhasil dibuat`,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload page
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Gagal membuat akun';

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join('\n');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMessage
                    });
                }
            });
        }

        /**
         * View user detail
         * @param {string} userId - ID pengguna
         */
        function viewUserDetail(userId) {
            $.ajax({
                url: `/admin/users/${userId}`,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const user = response.data;
                        let detailHtml = `
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar-lg rounded-circle bg-primary mx-auto mb-3">
                                <span class="avatar-title text-white" style="font-size: 2rem;">
                                    ${user.name.charAt(0)}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td>${user.name}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>${user.email}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        <span class="badge ${getRoleBadgeClass(user.role)}">
                                            ${getRoleLabel(user.role)}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge ${user.status === 'active' ? 'bg-success' : 'bg-secondary'}">
                                            ${user.status === 'active' ? 'Aktif' : 'Tidak Aktif'}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Daftar:</strong></td>
                                    <td>${new Date(user.created_at).toLocaleDateString('id-ID')}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;

                        $('#userDetailContent').html(detailHtml);
                        $('#userDetailModal').modal('show');
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat detail pengguna'
                    });
                }
            });
        }

        /**
         * Delete user
         * @param {string} userId - ID pengguna
         * @param {string} userName - Nama pengguna
         */
        function deleteUser(userId, userName) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus pengguna "${userName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/users/${userId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Pengguna berhasil dihapus',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus pengguna'
                            });
                        }
                    });
                }
            });
        }

        /**
         * Update statistics display
         * Memperbarui tampilan statistik di cards
         */
        function updateStatistics() {
            $.ajax({
                url: '/admin/api/statistics',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#totalMembers').text(stats.total_members || 0);
                        $('#totalFinance').text(stats.total_finance || 0);
                        $('#totalCommittee').text(stats.total_committee || 0);
                        $('#totalActive').text(stats.total_active || 0);
                    }
                },
                error: function(xhr) {
                    console.error('Failed to update statistics:', xhr);
                }
            });
        }

        /**
         * Helper function to get role badge class
         * @param {string} role - Role pengguna
         * @returns {string} CSS class untuk badge
         */
        function getRoleBadgeClass(role) {
            switch(role) {
                case 'member': return 'bg-info';
                case 'finance_team': return 'bg-success';
                case 'event_committee': return 'bg-warning';
                case 'admin': return 'bg-danger';
                default: return 'bg-secondary';
            }
        }

        /**
         * Helper function to get role label
         * @param {string} role - Role pengguna
         * @returns {string} Label role dalam bahasa Indonesia
         */
        function getRoleLabel(role) {
            switch(role) {
                case 'member': return 'Member';
                case 'finance_team': return 'Tim Keuangan';
                case 'event_committee': return 'Panitia Kegiatan';
                case 'admin': return 'Administrator';
                default: return role;
            }
        }
    </script>
@endsection
