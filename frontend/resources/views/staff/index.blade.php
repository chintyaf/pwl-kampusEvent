@extends('layouts.back')
@section('content')
    <a class="logout-btn dropdown-item" data-url="/logout">
        <i class="bx bx-power-off me-2"></i>
        <span class="align-middle">Log Out</span>
    </a>
    <form id="logout-form" method="POST" style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@endsection
