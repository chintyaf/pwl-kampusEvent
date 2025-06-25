@extends('layouts.back')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Events/</span>New Event</h4>

        <div class="card">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">Hoverable rows</h5>
            </div>
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="px-4 mb-4">
                <form id="uploadZipForm" method="POST" enctype="multipart/form-data"
                    action="{{ route('events.uploadCert', [
                        'id' => (string) $event['_id'],
                        'session_id' => (string) $session['_id'],
                    ]) }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ (string) $user['id'] }}">
                    <input type="hidden" name="event_id" id="event_id" value="{{ (string) $event['_id'] }}">
                    <input type="hidden" name="session_id" id="session_id" value="{{ (string) $session['_id'] }}">
                    <div class="input-group">
                        <input type="file" class="form-control" name="certificate" id="certificate" accept=".zip" required
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload" />
                        <button class="btn btn-outline-primary" type="submit" id="inputGroupFileAddon04">Send</button>
                    </div>
                </form>
                {{-- <form id="uploadZipForm" enctype="multipart/form-data">
                    <input type="file" name="zipFile" id="zipFile" accept=".zip" required>
                    <button type="submit">Upload ZIP</button>
                </form> --}}


            </div>


            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Register Id</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Certificates</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (!empty($session['attending_user']) && is_iterable($session['attending_user']))
                            @foreach ($session['attending_user'] as $visitor)
                                <tr>
                                    <td>{{ (String) $visitor['user']['_id'] ?? '-' }}</td>
                                    <td>{{ $visitor['user']['user_id']['name'] ?? '-' }}</td>
                                    <td><span class="badge bg-label-primary me-1">{{ $visitor['status'] ?? '-' }}</span>
                                    <td>{{ $visitor['certificate'] ?? '-' }}</td>
                                    </td>
                                </tr>
                            @endforeach
                        @endif



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@push('extraJS')
<script>
    document.getElementById('uploadZipForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const certificate = document.getElementById('certificate').files[0];
        const userId = document.getElementById('user_id').value;
        const eventId = document.getElementById('event_id').value;
        const sessionId = document.getElementById('session_id').value;

        if (!certificate) {
            alert("Silakan pilih file ZIP terlebih dahulu.");
            return;
        }

        const formData = new FormData();
        formData.append('certificate', certificate); // field name harus "certificate"

        const uploadUrl =
            `http://localhost:3000/api/comite/${userId}/events/${eventId}/${sessionId}/uploadCert`;

        try {
            const response = await fetch(uploadUrl, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Upload failed');
            }

            alert(result.message);
        } catch (error) {
            console.error('Upload error:', error);
            alert('Upload gagal: ' + error.message);
        }
    });
</script>

@endpush
