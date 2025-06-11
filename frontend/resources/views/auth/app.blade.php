<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>Register | Evoria</title>

    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <!-- Optional logo -->
                                    <img src="../assets/img/favicon/favicon.ico" width="24" alt="logo" />
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder">Evoria</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-2">Create your account</h4>
                        <p class="mb-4">Please sign-up to get started</p>

                        <form id="registerForm" action="{{ route('register') }}" class="mb-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" required />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required />
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Create password" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Create password"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <input type="hidden" name="role" id="role" value="member">

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign up</button>
                            </div>

                            @if ($errors->any())
                                <div style="color: red;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endifP

                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}"><span>Sign in instead</span></a>
                        </p>
                    </div>
                </div>
                <!-- /Register Card -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Register Script -->
    <script>
        const registerForm = document.getElementById('registerForm');

        registerForm.addEventListener('submit', async function(e) {
                        e.preventDefault(); <
                        !DOCTYPE html >
                            <
                            html >
                            <
                            head >
                            <
                            title > Register < /title> < /
                        head > <
                            body >
                            <
                            h1 > Member Registration < /h1>

                            <
                            form id = "registerForm" >
                            <
                            input type = "text"
                        name = "name"
                        placeholder = "Name"
                        required > < br > < br >
                            <
                            input type = "email"
                        name = "email"
                        placeholder = "Email"
                        required > < br > < br >
                            <
                            input type = "password"
                        name = "password"
                        placeholder = "Password"
                        required > < br > < br >
                            <
                            button type = "submit" > Register < /button> < /
                        form >

                            const registerForm = document.getElementById('registerForm');

                        registerForm.addEventListener('submit', async function(e) {
                            e.preventDefault();

                            const form = e.target;
                            const data = {
                                name: form.name.value,
                                email: form.email.value,
                                password: form.password.value
                            };

                            try {
                                const response = await fetch('http://localhost:3000/register', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify(data)
                                });

                                const result = await response.json();

                                if (response.ok) {
                                    alert(result.message || 'Registered successfully!');
                                    form.reset();
                                    window.location.href =
                                        "/login"; // pindah ke halaman login setelah register berhasil
                                } else {
                                    alert(result.message || 'Registration failed!');
                                }
                            } catch (error) {
                                alert('Error connecting to server');
                                console.error(error);
                            }
                        });
    </script>
</body>

</html>
