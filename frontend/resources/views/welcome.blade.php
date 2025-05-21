{{-- <!DOCTYPE html>
<html>
<head>
    <title>Laravel Frontend</title>
</head>
<body>
    <h1>Message from Node.js Backend:</h1>
    <div id="message">Loading...</div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        axios.get('http://localhost:5000/api/message')
            .then(response => {
                document.getElementById('message').innerText = response.data.message;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    </script>
</body>
</html> --}}

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Create User (Sends to Node.js Backend)</h1>

    <form id="userForm">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <button type="submit">Send</button>
    </form>

    <h2>User List</h2>
    <ul id="userList"></ul>

    <script>
        const userForm = document.getElementById('userForm');
        const userList = document.getElementById('userList');

        async function fetchUsers() {
            const res = await fetch('http://localhost:3000/users');
            const users = await res.json();

            userList.innerHTML = ''; // Clear existing list

            users.forEach(user => {
                const li = document.createElement('li');
                li.textContent = ${user.name} (${user.email});
                userList.appendChild(li);
            });
        }

        userForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = e.target;
            const data = {
                name: form.name.value,
                email: form.email.value
            };

            await fetch('http://localhost:3000/users', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            form.reset();
            fetchUsers(); // Refresh list after submitting
        });

        // Fetch users on page load
        fetchUsers();
    </script>
</body>
</html>