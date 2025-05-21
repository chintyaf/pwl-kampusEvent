@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome {{ Auth::user()->name }}!
                    <p>Your role: {{ Auth::user()->role }}</p>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Manage Users</a>
                    @endif

                    @if(Auth::user()->role === 'member')
                        <a href="{{ route('events.index') }}" class="btn btn-primary">View Events</a>
                    @endif

                    @if(Auth::user()->role === 'finance_team')
                        <a href="{{ route('finance.payments') }}" class="btn btn-primary">Manage Payments</a>
                    @endif

                    @if(Auth::user()->role === 'event_committee')
                        <a href="{{ route('committee.events') }}" class="btn btn-primary">Manage Events</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection