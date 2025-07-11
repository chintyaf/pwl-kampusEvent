@extends('layouts.back')
@push('extraCSS')
@endpush

@section('content')
    @foreach ($event as $event)
        <div class="card" style="margin:70px">
            <h5 class="card-header">Hoverable rows</h5>
            <div class="table-responsive text-nowrap" style="overflow-x:clip">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Session</th>
                            {{-- <th>Status</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        @foreach ($event['session'] as $session)
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>{{ $session['title'] }}</strong>
                                </td>
                                {{-- <td><span class="badge bg-label-primary me-1">{{ $session['status'] }}</span></td> --}}
                                <td>
                                    {{-- <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('events.scan-qr', [
                                                    'id' => (string) $event['_id'],
                                                    'session_id' => (string) $session['_id'],
                                                ]) }}">Scan
                                                QR</a>
                                            <a class="dropdown-item"
                                                href="{{ route('events.view-attendacesess', [
                                                    'id' => (string) $event['_id'],
                                                    'session_id' => (string) $session['_id'],
                                                ]) }}">View
                                                Attendee </a>
                                        </div>
                                    </div> --}}
                                    <a class="btn btn-primary"
                                        href="{{ route('events.scan-qr', [
                                            'id' => (string) $event['_id'],
                                            'session_id' => (string) $session['_id'],
                                        ]) }}">Scan
                                        QR</a>
                                    <a class="btn btn-outline-primary"
                                        href="{{ route('events.view-attendacesess', [
                                            'id' => (string) $event['_id'],
                                            'session_id' => (string) $session['_id'],
                                        ]) }}">View
                                        Attendee </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a {{-- href="{{ route('events.view-attendacesess', [
                    'id' => (string) $event['_id'],
                    'session_id' => (string) $session['_id'],
                ]) }}">
                Session: {{ $session['title'] }} --}} </a>
        </div>
        {{-- <div class="container-xxl flex-grow-1 container-p-y"> --}}
        {{-- </div> --}}
    @endforeach
@endsection
{{--

              <div class="card">
                <h5 class="card-header">Hoverable rows</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Users</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
                        <td>Albert Cook</td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title="Lilian Fuller"
                            >
                              <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title="Sophia Wilkerson"
                            >
                              <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title="Christina Parker"
                            >
                              <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                            </li>
                          </ul>
                        </td>
                        <td><span class="badge bg-label-primary me-1">Active</span></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div> --}}
