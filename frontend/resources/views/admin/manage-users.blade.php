@extends('layouts.back')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Kelola Pengguna</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="openCreateModal()">+ Tambah Pengguna</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="usersTable">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="7" class="text-center">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit / Tambah -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="editUserForm">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Form Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="userId">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" class="form-control" id="password">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select class="form-select" id="role" required>
                <option value="">-- Pilih --</option>
                <option value="member">Member</option>
                <option value="finance_team">Tim Keuangan</option>
                <option value="event_committee">Panitia Kegiatan</option>
                <option value="admin">Administrator</option>
            </select>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="is_active" checked>
            <label class="form-check-label" for="is_active">Aktif</label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
{{-- <script> --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.querySelector("#usersTable tbody");
    console.log("TABEL:", tbody); // <--- Tambahkan debug ini

    fetch("http://localhost:3000/api/users")
        .then(res => res.json())
        .then(data => {
            console.log("DATA:", data); // <--- Tambahkan debug ini
            if (!tbody) return alert("tbody not found!");

            tbody.innerHTML = "";

            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center">Tidak ada pengguna.</td></tr>`;
                return;
            }

            data.forEach((user, index) => {
                tbody.innerHTML += `<tr><td>${index + 1}</td><td>${user.name}</td><td>${user.email}</td><td>${user.role}</td><td>${user.is_active ? 'Aktif' : 'Tidak Aktif'}</td><td>${new Date(user.createdAt).toLocaleDateString()}</td><td><button>Edit</button></td></tr>`;
            });
        })
        .catch(err => {
            console.error("Fetch error:", err);
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-danger text-center">Gagal memuat data.</td></tr>`;
            }
        });
});
</script>

// document.addEventListener("DOMContentLoaded", () => {
//     fetch("http://localhost:3000/api/users")
//         .then(res => res.json())
//         .then(data => {
//             const tbody = document.querySelector("#usersTable tbody");
//             tbody.innerHTML = "";

//             if (data.length === 0) {
//                 tbody.innerHTML = `<tr><td colspan="7" class="text-center">Tidak ada pengguna.</td></tr>`;
//                 return;
//             }

//             data.forEach((user, index) => {
//                 const roleLabel = {
//                     member: 'Member',
//                     finance_team: 'Tim Keuangan',
//                     event_committee: 'Panitia Kegiatan',
//                     admin: 'Administrator'
//                 }[user.role] || user.role;

//                 const badgeClass = {
//                     member: 'bg-info',
//                     finance_team: 'bg-success',
//                     event_committee: 'bg-warning',
//                     admin: 'bg-danger'
//                 }[user.role] || 'bg-secondary';

//                 const activeLabel = user.is_active ? 'Aktif' : 'Tidak Aktif';
//                 const checked = user.is_active ? 'checked' : '';

//                 tbody.innerHTML += `
//                     <tr>
//                         <td>${index + 1}</td>
//                         <td>${user.name}</td>
//                         <td>${user.email}</td>
//                         <td><span class="badge ${badgeClass}">${roleLabel}</span></td>
//                         <td>
//                             <div class="form-check form-switch">
//                                 <input class="form-check-input" type="checkbox" ${checked}
//                                     onchange="toggleStatus('${user._id}', this.checked)">
//                                 <label class="form-check-label">${activeLabel}</label>
//                             </div>
//                         </td>
//                         <td>${new Date(user.createdAt || user.created_at).toLocaleDateString('id-ID')}</td>
//                         <td>
//                             <button class="btn btn-sm btn-warning" onclick="editUser('${user._id}')">Edit</button>
//                             <button class="btn btn-sm btn-danger" onclick="deleteUser('${user._id}', '${user.name}')">Hapus</button>
//                         </td>
//                     </tr>
//                 `;
//             });
//         })
//         .catch(err => {
//             console.error("Gagal ambil data:", err);
//             const tbody = document.querySelector("#usersTable tbody");
//             tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Gagal memuat data pengguna.</td></tr>`;
//         });
// });
{{-- </script> --}}
@endsection

