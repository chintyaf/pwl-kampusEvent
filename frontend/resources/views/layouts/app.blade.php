<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth System')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <nav>
            <div>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                @if(Session::has('user'))
                    <span>Welcome, {{ Session::get('user')['name'] }}</span>
                    <span>Role: {{ Session::get('user')['role'] }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @endif
            </div>
        </nav>
    </header>

    <main>
        @if(session('success'))
            <div style="color: green; padding: 10px; border: 1px solid green; margin: 10px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="color: red; padding: 10px; border: 1px solid red; margin: 10px;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
