<!DOCTYPE html>
<html>
<head>
    <title>Kelola Tim</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Kelola Tim Keuangan & Panitia Kegiatan</h1>

    <h2>Tambah Pengguna</h2>
    <form id="addUserForm">
        <input type="text" name="name" placeholder="Nama" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <select name="role" id="roleSelect" required>
            <option value="">Pilih Role</option>
            <option value="finance_team">Tim Keuangan</option>
            <option value="event_committee">Panitia Kegiatan</option>
        </select><br><br>

        <!-- Event selection (hidden by default) -->
        <select name="event" id="eventSelect" style="display:none;">
            <option value="">Pilih Event</option>
            <option value="Event A">Event A</option>
            <option value="Event B">Event B</option>
            <option value="Event C">Event C</option>
        </select><br><br>

        <button type="submit">Tambah</button>
    </form>

    <hr>

    <h2>Daftar Tim</h2>
    <table border="1" id="userTable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Event</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        const userTable = document.querySelector('#userTable tbody');
        const roleSelect = document.getElementById('roleSelect');
        const eventSelect = document.getElementById('eventSelect');

        // Show/hide event dropdown based on role selection
        roleSelect.addEventListener('change', () => {
            if (roleSelect.value === 'event_committee') {
                eventSelect.style.display = 'inline-block';
                eventSelect.required = true;
            } else {
                eventSelect.style.display = 'none';
                eventSelect.required = false;
                eventSelect.value = '';
            }
        });

        async function fetchUsers() {
            const res = await fetch('http://localhost:3000/admin/users');
            const users = await res.json();

            userTable.innerHTML = '';
            users.forEach(user => {
                if (['finance_team', 'event_committee'].includes(user.role)) {
                    const eventName = user.event ? user.event : '-';
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>${eventName}</td>
                        <td>${user.is_active ? 'Aktif' : 'Nonaktif'}</td>
                        <td>
                            <button onclick="toggleStatus('${user._id}', ${!user.is_active})">${user.is_active ? 'Nonaktifkan' : 'Aktifkan'}</button>
                            <button onclick="deleteUser('${user._id}')">Hapus</button>
                        </td>
                    `;
                    userTable.appendChild(row);
                }
            });
        }

        async function toggleStatus(id, status) {
            await fetch(`http://localhost:3000/admin/users/${id}/status`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ is_active: status })
            });
            fetchUsers();
        }

        async function deleteUser(id) {
            await fetch(`http://localhost:3000/admin/users/${id}`, {
                method: 'DELETE'
            });
            fetchUsers();
        }

        document.getElementById('addUserForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const data = {
                name: form.name.value,
                email: form.email.value,
                password: form.password.value,
                role: form.role.value,
            };

            // Sertakan event jika role adalah event_committee
            if (data.role === 'event_committee') {
                data.event = form.event.value;
            }

            await fetch('http://localhost:3000/admin/users', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            form.reset();
            eventSelect.style.display = 'none';
            fetchUsers();
        });

        fetchUsers();
    </script>
</body>
</html>
