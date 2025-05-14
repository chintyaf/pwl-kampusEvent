<!DOCTYPE html>
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
</html>
