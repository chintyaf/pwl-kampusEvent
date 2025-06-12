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
                    <option value="mandiri">Transfer Mandiri - 9876543210 a.n. Event Organizer
                    </option>
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
