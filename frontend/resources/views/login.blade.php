<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Login</h1>

    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <script>
        const loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = e.target;
            const data = {
                email: form.email.value,
                password: form.password.value
            };

            const response = await fetch('http://localhost:3000/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                // Redirect based on role
                const role = result.user.role;
                if (role === "admin") {
                    window.location.href = "/admin";
                } else if (role === "finance_team") {
                    window.location.href = "/finance";
                } else if (role === "event_committee") {
                    window.location.href = "/committee";
                } else if (role === "event_staff") {
                    window.location.href = "/staff";
                } else if (role === "member") {
                    window.location.href = "/member";
                } else {
                    window.location.href = "/guest";
                }
            } else {
                alert(result.message || "Login failed");
            }
        });
    </script>
</body>
</html>
