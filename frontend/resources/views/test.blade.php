<!DOCTYPE html>
<html>
<head>
  <title>QR Check-in</title>
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
  <h2>Scan QR</h2>
  <div id="reader" style="width:300px;"></div>
  <div id="result" style="margin-top:20px; font-size:18px;"></div>

<script>
  function onScanSuccess(decodedText) {
    // Log the decodedText to verify what the QR code actually returns
    console.log("Scanned QR Text:", decodedText);

    // decodedText should just be the token like "abc123"
    fetch(`http://localhost:3000/verify?token=${encodeURIComponent(decodedText.trim())}`)
      .then(res => res.json())
      .then(data => {
        const result = document.getElementById('result');
        if (data.user) {
          result.innerHTML = `<b>✅ ${data.message}</b><br>Nama: ${data.user.name}`;
        } else {
          result.innerHTML = `<b>⚠️ ${data.message}</b>`;
        }
      })
      .catch(err => {
        document.getElementById('result').innerText = 'Gagal koneksi ke server.';
        console.error(err);
      });
  }

  new Html5Qrcode("reader").start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 250 },
    onScanSuccess
  );
</script>

</body>
</html>
