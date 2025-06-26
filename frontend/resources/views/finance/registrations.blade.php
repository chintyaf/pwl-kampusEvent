 @extends('layouts.back')

@section('content')
<div class="container">
    <h2>Daftar Pembayaran Event</h2>
    <table id="paymentTable" class="table table-bordered">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Event ID</th>
                <th>Status</th>
                <th>Metode</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal untuk Detail -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>User ID:</strong> <span id="detailUser"></span></p>
        <p><strong>Event ID:</strong> <span id="detailEvent"></span></p>
        <p><strong>Status:</strong> <span id="detailStatus"></span></p>
        <p><strong>Metode:</strong> <span id="detailMethod"></span></p>
        <img id="detailImage" src="" class="img-fluid" />
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="updateStatus('approved')">Approve</button>
        <button class="btn btn-danger" onclick="updateStatus('rejected')">Reject</button>
      </div>
    </div>
  </div>
</div>

<script>
let selectedId = null;

function fetchPayments() {
    fetch("/event-register/view-payment")
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#paymentTable tbody");
            tbody.innerHTML = "";
            data.forEach(item => {
                const row = `
                    <tr>
                        <td>${item.user_id?.name || '-'}</td>
                        <td>${item.event_id?.name || '-'}</td>

                        <td>${item.payment.status}</td>
                        <td>${item.payment.method}</td>
                        <td><img src="/${item.payment.proof_image_url}" width="80"/></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="viewDetail('${item._id}')">Detail</button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        });
}

function viewDetail(id) {
    selectedId = id;
    fetch(`/event-register/view-payment/${id}`)
        .then(res => res.json())
        .then(item => {
            document.getElementById("detailUser").textContent = item.user_id;
            document.getElementById("detailEvent").textContent = item.event_id;
            document.getElementById("detailStatus").textContent = item.payment.status;
            document.getElementById("detailMethod").textContent = item.payment.method;
            document.getElementById("detailImage").src = "/" + item.payment.proof_image_url;
            new bootstrap.Modal(document.getElementById('paymentModal')).show();
        });
}

function updateStatus(status) {
    if (!selectedId) return;
    fetch(`/event-register/view-payment/${selectedId}/update`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ status }),
    })
    .then(res => res.json())
    .then(resp => {
        alert(resp.message || "Berhasil memperbarui status.");
        fetchPayments();
        bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
    });
}

document.addEventListener("DOMContentLoaded", fetchPayments);
</script>
@endsection


{{--@section('title', 'Daftar Pembayaran')

@section('content')
    <div class="container">
        <h2>Daftar Pembayaran</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nama Event</th>
                <th>Nama Member</th>
                <th>Email Member</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($registrations as $registration)
                <tr>
                    <td>{{ $registration['eventId']['name'] }}</td>
                    <td>{{ $registration['memberName'] }}</td>
                    <td>{{ $registration['memberEmail'] }}</td>
                    <td>{{ $registration['paymentStatus'] }}</td>
                    <td>
                        <form action="{{ route('finance.update.status', $registration['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="paymentStatus" class="form-control">
                                <option value="pending" {{ $registration['paymentStatus'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $registration['paymentStatus'] == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="verified" {{ $registration['paymentStatus'] == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ $registration['paymentStatus'] == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-success mt-2">Update Status</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection --}}
