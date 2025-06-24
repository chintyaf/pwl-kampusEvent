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
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('events.uploadCert', [
                        'id' => (string) $session['_id'],
                        'session_id' => (string) $session['_id'],
                    ]) }}">
                    @csrf
                    <div class="input-group">
                        <input type="file" class="form-control" id="inputGroupFile04" name="zipFile"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload" />
                        <button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Send to
                            Attenddee</button>
                    </div>
                </form>
            </div>


            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Certificates</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (!empty($session['attending_user']) && is_iterable($session['attending_user']))
                            @foreach ($session['attending_user'] as $visitor)
                                @php
                                    $user = $visitor['user'] ?? null;
                                @endphp

                                @if (is_array($user))
                                    <tr>
                                        <td>{{ $user['name'] ?? '-' }}</td>
                                        <td><span class="badge bg-label-primary me-1">{{ $visitor['status'] ?? '-' }}</span>
                                        <td>{{ $visitor['certificate'] ?? '-' }}</td>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('extraJS')
    c
@endsection
