@extends('layouts.front')
@section('content')
    <section id="event-register" class="section" style="margin: 40px; margin-top: 0px;">
        <div class="detail-section">
            <div class="container">
                <form id="formInput">
                    {{-- Input user + events --}}
                    <input type="hidden" name="user_id" id="user_id" value="682d81260dc7fc62f4eb0a6f">
                    <input type="hidden" name="event_id" id="event_id" value="{{ $event['_id'] }}">

                    <!-- Informasi Event -->
                    <div class="detail-card">
                        <div class="mb-4">
                            <h4 class="mb-3 form-title">Event Information</h4>
                            <hr>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Event</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" value="{{ $event['name'] }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-4">
                                    <input type="text" readonly class="form-control"
                                        value="{{ \Carbon\Carbon::parse($event['date'])->format('l, F j Y') }}" disabled>
                                </div>
                                <label class="col-sm-2 col-form-label">Harga per Tiket</label>
                                <div class="col-sm-4">
                                    <input type="text" readonly class="form-control" value="Rp 150.000 /person" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pendaftar Utama -->
                    <div class="detail-card">
                        <div class="mb-4">
                            <h4 class="mb-3 form-title">Visitors Data</h4>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-secondary" onclick="addVisitor()">➕ Tambah
                                        Pengunjung</button>
                                </div>
                            </div>
                            <div id="visitorsContainer" class="mb-3">
                                <!-- Dynamic visitors will be appended here -->
                                <div class="visitor-list" id="visitorsContainer">
                                    <div class="visitor-item" id="visitor-0">
                                        <div class="visitor-header d-flex justify-content-between mb-1">
                                            <span class="visitor-number fw-semibold">Pengunjung 1</span>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="mainName" class="col-sm-2 col-form-label">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="visitors[0][name]"
                                                    id="mainName" value="Chin" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="mainEmail" class="col-sm-2 col-form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="visitors[0][email]"
                                                    value="chin@gmail.com" id="mainEmail" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="mainPhone" class="col-sm-2 col-form-label">No. Telepon <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="tel" class="form-control" name="visitors[0][phone_num]"
                                                    value="089693569965" id="mainPhone" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Total Pembayaran -->
                    <div class="detail-card">



                        <div class="mb-4">
                            <h4 class="mb-3 form-title">Total Payments</h4>
                            <hr>
                            <div class="row mb-2">
                                <label class="col-sm-2 col-form-label">Total Ticket</label>
                                <div class="col-sm-10">
                                    <div id="ticketCount" class="form-control-disabled">1 Tiket</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-2 col-form-label">Total</label>
                                <div class="col-sm-10">
                                    <div id="totalAmount" class="form-control-disabled">Rp 150.000</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Payment Confirmation Form Section -->
                    <div class="detail-card">
                        <div class="mb-4">
                            <h4 class="mb-3 form-title">Payment Confirmations</h4>
                            <hr>

                            <!-- Order Details -->
                            <div class="mb-3">
                                <h6 class="mb-2">Order detail:</h6>
                                <div class="d-flex justify-content-between mb-4">
                                    <span>Workshop Web Development 2025</span>
                                    <span id="summaryTickets">1 x Rp 150.000</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <strong>Total Pembayaran</strong>
                                    <strong id="summaryTotal">Rp 150.000</strong>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="row mb-3">
                                <label for="paymentMethod" class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                <div class="col-sm-10">
                                    <select id="paymentMethod" name="payment[method]" class="form-select" required>
                                        <option value="">Pilih Metode Pembayaran</option>
                                        <option value="bca">Transfer BCA - 1234567890 a.n. Event Organizer</option>
                                        <option value="mandiri">Transfer Mandiri - 9876543210 a.n. Event Organizer</option>
                                        <option value="bni">Transfer BNI - 5555666677 a.n. Event Organizer</option>
                                        <option value="bri">Transfer BRI - 1111222233 a.n. Event Organizer</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Upload Bukti Pembayaran -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Upload Bukti</label>
                                <div class="col-sm-10">
                                    <div class="border p-3 text-center upload-area" style="cursor: pointer;"
                                        onclick="document.getElementById('paymentProof').click()">
                                        <p><strong>Klik untuk upload</strong> atau drag & drop file di sini</p>
                                        <small class="text-muted">Format: JPG, PNG, PDF (Max. 5MB)</small>
                                    </div>
                                    <input type="file" name="payment_proof" id="paymentProof" accept="image/*,.pdf"
                                        style="display: none;" required>
                                    <div class="mt-2 d-flex justify-content-between align-items-center" id="filePreview"
                                        style="display: none;">
                                        <span id="fileName"></span>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="removeFile()">✕</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Submit Button -->
                    <div class="row mb-5">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div style="background-color: gray;">
            <a href="/event1/payment">Continue</a>
        </div>
    </section>
@endsection
@section('extraJS')
    <script>
        let visitorCount = 1;
        const ticketPrice = 150000;

        function addVisitor() {
            const visitorsContainer = document.getElementById('visitorsContainer');

            const visitorDiv = document.createElement('div');
            visitorDiv.className = 'visitor-item';
            visitorDiv.id = `visitor-${visitorCount}`;

            visitorDiv.innerHTML = `
                    <div class="visitor-header d-flex justify-content-between mb-1">
                        <span class="visitor-number fw-semibold">Pengunjung ${visitorCount + 1}</span>
                        <button type="button" class="remove-visitor" onclick="removeVisitor(${visitorCount})">X</button>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="visitors[${visitorCount}][name]" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="visitors[${visitorCount}][email]" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">No. Telepon <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" name="visitors[${visitorCount}][phone_num]" required>
                        </div>
                    </div>
                `;

            visitorsContainer.appendChild(visitorDiv);
            updateTotal();
            visitorCount++;
        }



        function removeVisitor(id) {
            const visitorDiv = document.getElementById(`visitor-${id}`);
            if (visitorDiv) {
                visitorDiv.remove();
                renumberVisitors();
                updateTotal();
            }
        }

        function renumberVisitors() {
            const visitorsContainer = document.getElementById('visitorsContainer');
            const visitorItems = visitorsContainer.querySelectorAll('.visitor-item');

            visitorItems.forEach((item, index) => {
                const newId = index + 1;
                item.id = `visitor-${newId}`;
                const numberSpan = item.querySelector('.visitor-number');
                numberSpan.textContent = `Pengunjung ${newId}`;

                const removeButton = item.querySelector('.remove-visitor');
                removeButton.setAttribute('onclick', `removeVisitor(${newId})`);
            });

            visitorCount = visitorItems.length; // Update global counter
        }


        function updateTotal() {
            const totalTickets = document.querySelectorAll('.visitor-item').length;
            // const totalTickets = visitorCount;
            const totalAmount = totalTickets * ticketPrice;

            document.getElementById('ticketCount').textContent = `${totalTickets} Tiket`;
            document.getElementById('totalAmount').textContent = `Rp ${totalAmount.toLocaleString('id-ID')}`;
            document.getElementById('summaryTickets').textContent =
                `${totalTickets} x Rp ${ticketPrice.toLocaleString('id-ID')}`;
            document.getElementById('summaryTotal').innerHTML =
                `<strong>Rp ${totalAmount.toLocaleString('id-ID')}</strong>`;
        }

        // File upload handling
        const uploadArea = document.querySelector('.upload-area');
        const fileInput = document.getElementById('paymentProof');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileUpload(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {

            if (e.target.files.length > 0) {
                handleFileUpload(e.target.files[0]);
            }
        });

        function handleFileUpload(file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                return;
            }

            fileName.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            filePreview.style.display = 'block';
        }

        function removeFile() {
            fileInput.value = '';
            filePreview.style.display = 'none';
        }

        // Form submission
        // document.getElementById('eventForm').addEventListener('submit', (e) => {
        //     e.preventDefault();

        //     // Validate required fields
        //     const requiredFields = document.querySelectorAll('[required]');
        //     let isValid = true;

        //     requiredFields.forEach(field => {
        //         if (!field.value.trim()) {
        //             field.style.borderColor = '#ff4757';
        //             isValid = false;
        //         } else {
        //             field.style.borderColor = '#e0e0e0';
        //         }
        //     });

        //     if (!isValid) {
        //         alert('Mohon lengkapi semua field yang wajib diisi!');
        //         return;
        //     }

        //     // Success message
        //     // alert(
        //     //     'Registrasi berhasil! Kami akan mengirimkan konfirmasi ke email Anda dalam 1x24 jam setelah verifikasi pembayaran.'
        //     // );

        //     // Here you would normally send the form data to your server
        //     // console.log('Form submitted successfully!');
        // });

        // Initialize
        updateTotal();
    </script>

    <script>
        document.querySelector('#formInput').addEventListener('submit', async function(e) {
            console.log(document.querySelector('#formInput'));
            e.preventDefault();

            const form = e.target;
            const visitorGroups = document.querySelectorAll('.visitor-item');
            const visitors = [];

            visitorGroups.forEach(group => {
                const name = group.querySelector('input[name*="[name]"]')?.value;
                const email = group.querySelector('input[name*="[email]"]')?.value;
                const phone_num = group.querySelector('input[name*="[phone_num]"]')?.value;

                if (name && email && phone_num) {
                    visitors.push({
                        name: name,
                        email: email,
                        phone_num: phone_num
                    });
                }
            });

            console.log(visitors)

            const method = document.querySelector('#paymentMethod')?.value;
            const proofFile = document.querySelector('#paymentProof')?.files[0];

            // You must upload the file first to get the URL
            // const proof_image_url = await uploadFileToCloud(proofFile); // implement this
            const proof_image_url = "test.png"

            const data = {
                user_id: document.getElementById("user_id").value,
                event_id: document.getElementById("event_id").value,
                visitors: visitors,
                payment: {
                    method,
                    proof_image_url
                }
            };
            // console.log(response)

            try {
                const response = await fetch('http://localhost:3000/api/member/event/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alert(result.message || 'New event added successfully!');
                    form.reset();
                    window.location.href = "";
                } else {
                    alert(result.message || 'Failed to add event');
                }
            } catch (error) {
                alert('Error connecting to server');
                console.error(error);
            }
        });
    </script>
@endsection
