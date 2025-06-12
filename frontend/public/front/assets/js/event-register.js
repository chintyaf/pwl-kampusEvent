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

function addVisitor() {
    const visitorsContainer = document.getElementById("visitors-list");

    const visitorDiv = document.createElement("div");
    // visitorDiv.className = "visitor-item";

    fetch("/render-visitor")
        .then((response) => response.text())
        .then((html) => {
            visitorDiv.innerHTML = html;
            visitorsContainer.appendChild(visitorDiv); // append only after innerHTML is set
            renumber("visitor"); // renumber after DOM is updated
        })
        .catch((error) => console.error("Error:", error));
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
    const visitorsContainer = document.getElementById("visitorsContainer");
    const visitorItems = visitorsContainer.querySelectorAll(".visitor-item");

    visitorItems.forEach((item, index) => {
        const newId = index + 1;
        item.id = `visitor-${newId}`;
        const numberSpan = item.querySelector(".visitor-number");
        numberSpan.textContent = `Pengunjung ${newId}`;

        const removeButton = item.querySelector(".remove-visitor");
        removeButton.setAttribute("onclick", `removeVisitor(${newId})`);
    });

    visitorCount = visitorItems.length; // Update global counter
}

function updateTotal() {
    const totalTickets = document.querySelectorAll(".visitor-item").length;
    // const totalTickets = visitorCount;
    const totalAmount = totalTickets * ticketPrice;

    document.getElementById(
        "ticketCount"
    ).textContent = `${totalTickets} Tiket`;
    document.getElementById(
        "totalAmount"
    ).textContent = `Rp ${totalAmount.toLocaleString("id-ID")}`;
    document.getElementById(
        "summaryTickets"
    ).textContent = `${totalTickets} x Rp ${ticketPrice.toLocaleString(
        "id-ID"
    )}`;
    document.getElementById(
        "summaryTotal"
    ).innerHTML = `<strong>Rp ${totalAmount.toLocaleString("id-ID")}</strong>`;
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
