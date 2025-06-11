<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  {{-- data-assets-path="{{ asset('back/assets/') }}/" --}}
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('back/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/css/theme-default.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('back/assets/css/demo.css') }}" /> --}}

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('back/assets/vendor/js/helpers.js') }}"></script>
    {{-- <script src="{{ asset('back/assets/js/config.js') }}"></script> --}}
  </head>

  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Login Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="{{ url('/') }}" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="{{ asset('back/assets/img/favicon/favicon.ico') }}" width="25" />
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">Evoria</span>
                </a>
              </div>

              <h4 class="mb-2">Welcome!</h4>
              <p class="mb-4">Please sign in to your account</p>

              <form id="loginForm" action={{ route('login-auth') }} method="POST" class="mb-3">
              @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="••••••••"
                      value="12345678"
                      required
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button type="submit" class="btn btn-primary d-grid w-100">Login</button>
                </div>
              </form>

              <p class="text-center">
                <span>Don't have an account?</span>
                <a href="{{ url('/register') }}">Create an account</a>
              </p>

              <div id="error-message" class="text-danger text-center"></div>
            </div>
          </div>
          <!-- /Login Card -->
        </div>
      </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('back/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('back/assets/js/main.js') }}"></script>

    <!-- Login Script -->
    {{-- <script>
      document.getElementById('loginForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('error-message');

        try {
          const response = await fetch('http://localhost:3000/login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
          });

          const result = await response.json();

          if (response.ok) {
            const role = result.user.role;
            if (role === 'admin') {
              window.location.href = '/admin';
            } else if (role === 'finance_team') {
              window.location.href = '/finance';
            } else if (role === 'event_committee') {
              window.location.href = '/event-committee';
            } else if (role === 'member') {
              window.location.href = '/member';
            } else {
              window.location.href = '/';
            }
          } else {
            errorMessage.textContent = result.message || 'Login failed.';
          }
        } catch (error) {
          console.error(error);
          errorMessage.textContent = 'Something went wrong. Please try again.';
        }
      });
    </script> --}}
  </body>
</html>
