@extends('layouts.back')

@section('title', 'Registrasi Peserta')

@section('content')
<div class="container-fluid py-4">
    <h4>Daftar Registrasi Peserta</h4>
    <div class="table-responsive">
        <table id="registrationsTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Metode</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="8" class="text-center">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="statusForm">
        <div class="modal-header">
            <h5 class="modal-title">Update Status Pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="selectedId">
            <p><strong>Nama:</strong> <span id="modalName"></span></p>
            <p><strong>Event:</strong> <span id="modalEvent"></span></p>
            <div class="mb-3">
                <label>Status Pembayaran</label>
                <select id="statusSelect" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
let registrations = [];

document.addEventListener('DOMContentLoaded', () => {
    loadRegistrations();

    document.getElementById('statusForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('selectedId').value;
        const status = document.getElementById('statusSelect').value;
        updateStatus(id, status);
    });
});

function loadRegistrations() {
    fetch('http://localhost:3000/event-register/view-payment')
        .then(res => res.json())
        .then(data => {
            registrations = data;
            renderTable(data);
        })
        .catch(err => {
            console.error("Gagal ambil data:", err);
            const tbody = document.querySelector("#registrationsTable tbody");
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Gagal memuat data.</td></tr>';
        });
}

function renderTable(data) {
    const tbody = document.querySelector('#registrationsTable tbody');
    tbody.innerHTML = "";

    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Tidak ada registrasi.</td></tr>';
        return;
    }

    data.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.user_id?.name || '-'}</td>
                <td>${item.user_id?.email || '-'}</td>
                <td>${item.event_id?.name || '-'}</td>
                <td><span class="badge bg-${getStatusColor(item.payment.status)}">${item.payment.status}</span></td>
                <td>${item.payment.method.toUpperCase()}</td>
                <td><img src="/${item.payment.proof_image_url}" width="80"/></td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="openStatusModal('${item._id}')">Update</button>
                </td>
            </tr>
        `;
    });
}

function getStatusColor(status) {
    switch (status) {
        case 'approved': return 'success';
        case 'pending': return 'warning';
        case 'rejected': return 'danger';
        default: return 'secondary';
    }
}

function openStatusModal(id) {
    const reg = registrations.find(r => r._id === id);
    if (!reg) return;

    document.getElementById('selectedId').value = id;
    document.getElementById('modalName').textContent = reg.user_id?.name || '-';
    document.getElementById('modalEvent').textContent = reg.event_id?.name || '-';
    document.getElementById('statusSelect').value = reg.payment.status;

    new bootstrap.Modal(document.getElementById('statusModal')).show();
}

function updateStatus(id, status) {
    fetch(`http://localhost:3000/event-register/view-payment/${id}/update`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ status }),
    })
    .then(res => res.json())
    .then(resp => {
        bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
        loadRegistrations();
    })
    .catch(err => {
        alert("Gagal update status.");
    });
}
</script>
@endsection
