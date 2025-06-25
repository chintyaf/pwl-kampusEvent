@extends('layouts.scan-back')
@section('content')
    <div class="container" style="margin:40px;margin-top:40px; width:100%; min-width:1000px ">
        <div class="card" style="padding:40px">
            <h2>Scan QR</h2>
            <div id="reader" style="width:50%;"></div>
            <div id="result" style="margin-top:20px; font-size:18px;"></div>
        </div>
    </div>
@endsection

@push('extraJS')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText) {
            // Log the decodedText to verify what the QR code actually returns
            console.log("Scanned QR Text:", decodedText);

            // decodedText should just be the token like "abc123"
            fetch(`http://localhost:3000/api/staff/re-register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: decodedText // this is already a stringified JSON from QR
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data)
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

        new Html5Qrcode("reader").start({
                facingMode: "environment"
            }, {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess
        );
    </script>
@endpush
