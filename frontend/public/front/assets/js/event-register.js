let visitorCount = 1;
const ticketPrice = 150000;

function renumber(type) {
    const items = document.querySelectorAll(`.${type}-item`);

    items.forEach((item, index) => {
        const newId = index + 1;
        item.id = `${type}-${newId}`;

        const numberSpan = item.querySelector(`.${type}-number`);
        if (numberSpan) {
            numberSpan.textContent = newId;
        }
    });
}

// File upload handling
const uploadArea = document.querySelector(".upload-area");
const fileInput = document.getElementById("paymentProof");
const filePreview = document.getElementById("filePreview");
const fileName = document.getElementById("fileName");

uploadArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    uploadArea.classList.add("dragover");
});

uploadArea.addEventListener("dragleave", () => {
    uploadArea.classList.remove("dragover");
});

uploadArea.addEventListener("drop", (e) => {
    e.preventDefault();
    uploadArea.classList.remove("dragover");
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        handleFileUpload(files[0]);
    }
});

fileInput.addEventListener("change", (e) => {
    if (e.target.files.length > 0) {
        handleFileUpload(e.target.files[0]);
    }
});

function handleFileUpload(file) {
    if (file.size > 5 * 1024 * 1024) {
        alert("Ukuran file terlalu besar. Maksimal 5MB.");
        return;
    }

    fileName.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(
        2
    )} MB)`;
    filePreview.style.display = "block";
}

function removeFile() {
    fileInput.value = "";
    filePreview.style.display = "none";
}

let selectedSessions = [];
// Add change event listeners to checkboxes
document.querySelectorAll(".session-checkbox").forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        const sessionCard = this.closest(".session-card");

        if (!sessionCard) return;

        const sessionId = sessionCard.dataset.sessionId;
        const fee = parseFloat(sessionCard.dataset.fee);
        const title = sessionCard.dataset.title;

        if (this.checked) {
            sessionCard.classList.add("selected");

            // ⬇️ Add session only if not already selected
            if (!selectedSessions.some((s) => s.id === sessionId)) {
                selectedSessions.push({
                    id: sessionId,
                    title: title,
                    fee: fee,
                });
            }
        } else {
            sessionCard.classList.remove("selected");

            selectedSessions = selectedSessions.filter(
                (s) => s.id !== sessionId
            );
        }

        updateRegistrationForm();
    });
});

function updateRegistrationForm() {
    const ticketCount = selectedSessions.length;
    const totalFee = selectedSessions.reduce((sum, session) => {
        return sum + session.fee;
    }, 0);

    const formatRupiah = (angka) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(angka);
    };

    document.getElementById("ticketCount").textContent = `${ticketCount} Tiket`;

    document.getElementById("totalFee").textContent = formatRupiah(totalFee);

    document.getElementById(
        "summaryTickets"
    ).textContent = `${ticketCount} x ${formatRupiah(
        totalFee / (ticketCount || 1)
    )}`;

    document.getElementById("summaryTotal").textContent =
        formatRupiah(totalFee);
}
