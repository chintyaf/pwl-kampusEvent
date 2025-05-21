<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Member Login</h1>

    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <script>
        const loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const data = {
                email: form.email.value,
                password: form.password.value,
            };

            try {
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
                    alert(result.message || 'Login successful!');
                    form.reset();
                    // Redirect ke home.blade.php (Laravel frontend)
                    window.location.href = '/home';
                } else {
                    alert(result.message || 'Login failed!');
                }
            } catch (error) {
                alert('Error connecting to server');
                console.error(error);
            }
        });
    </script>
</body>
</html>
