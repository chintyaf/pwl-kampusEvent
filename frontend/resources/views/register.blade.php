<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Member Registration</h1>

    <form id="registerForm">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <script>
        const registerForm = document.getElementById('registerForm');

        registerForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = e.target;
            const data = {
                name: form.name.value,
                email: form.email.value,
                password: form.password.value
            };

            try {
                const response = await fetch('http://localhost:3000/api/register', {
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
                    window.location.href = "/login";  // pindah ke halaman login setelah register berhasil
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
