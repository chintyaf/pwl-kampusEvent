@extends('layouts.front') 

@section('content')
<br>
<br>
<br>
<br>
<div class="container-xl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <div class="card">
        <div class="card-body">
          <div class="app-brand justify-content-center">
            <a href="/" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <!-- logo svg Anda -->
              </span>
              <span class="app-brand-text demo text-body fw-bolder">Evoria</span>
            </a>
          </div>
          <h4 class="mb-2">Adventure starts here 🚀</h4>
          <p class="mb-4">Make your app management easy and fun!</p>

          <form id="registerForm" class="mb-3">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Username</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" required />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required />
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  class="form-control"
                  name="password"
                  placeholder="••••••••••••"
                  required
                />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3 form-check">
              <input class="form-check-input" type="checkbox" id="terms" required />
              <label class="form-check-label" for="terms">
                I agree to <a href="#">privacy policy & terms</a>
              </label>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">
              <span>Sign in instead</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('registerForm').addEventListener('submit', async function(e) {
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
        window.location.href = "/login"; // Ubah sesuai route Laravel Anda
      } else {
        alert(result.message || 'Registration failed.');
      }
    } catch (error) {
      alert('Error registering. Please try again.');
    }
  });
</script>
@endsection
