@extends('layouts.back')

@section('title', 'Daftar Pembayaran')

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
@endsection
