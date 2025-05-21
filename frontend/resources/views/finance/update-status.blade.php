<!DOCTYPE html>
<html>
<head>
    <title>Update Payment Status</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Update Payment Status</h1>

    <form id="updateStatusForm">
        <input type="email" name="email" placeholder="User Email" required><br><br>
        <select name="status" required>
            <option value="">Select Status</option>
            <option value="true">Paid</option>
            <option value="false">Unpaid</option>
        </select><br><br>
        <button type="submit">Update Status</button>
    </form>

    <div id="response"></div>

    <script>
        const form = document.getElementById('updateStatusForm');
        const responseDiv = document.getElementById('response');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = form.email.value;
            const isActive = form.status.value === "true";

            try {
                const res = await fetch("http://localhost:3001/update-status", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ email, is_active: isActive })
                });

                const result = await res.json();
                responseDiv.textContent = result.message;
            } catch (err) {
                responseDiv.textContent = "Error: " + err.message;
            }
        });
    </script>
</body>
</html>
