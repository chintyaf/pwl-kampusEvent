@extends('layouts.admin')

@section('title', 'Add Committee')

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
{{--                        <div class="app-brand justify-content-center mb-4">--}}
{{--                            <a href="index.html" class="app-brand-link gap-2">--}}
{{--                                <span class="app-brand-logo demo">--}}
{{--                                    <img src="auth/assets/img/favicon/favicon.ico" width="24" alt="logo" />--}}
{{--                                </span>--}}
{{--                                <span class="app-brand-text demo text-body fw-bolder">Evoria</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                        <!-- /Logo -->

                        <h4 class="mb-2">Create Committee Account 🚀</h4>
                        <p class="mb-4">Please fill out the form to create a committee account</p>

                        <!-- Form action points to the storeCommittee route -->
                        <form action="{{ route('admin.store-committee') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="Create password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <input type="hidden" name="role" id="role" value="event_committee">

                            @if ($errors->any())
                                <div style="color: red;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Create Committee Account</button>
                            </div>
                        </form>

                        {{--                        <p class="text-center">--}}
{{--                            <span>Already have an account?</span>--}}
{{--                            <a href="{{ route('login') }}"><span>Sign in instead</span></a>--}}
{{--                        </p>--}}
                    </div>
                </div>
                <!-- /Register Card -->
            </div>
        </div>
    </div>
@endsection
