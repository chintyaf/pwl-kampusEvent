const QRCode = require("qrcode");

const userData = {
    name: "Jesye",
    token: "abc123",
    // status: "belum_hadir", // atau "hadir"
};
// Ubah data ke string
const qrData = JSON.stringify(userData);

// Generate ke file image
QRCode.toFile(
    "./budi-qr2.png",
    qrData,
    {
        color: {
            dark: "#000", // Warna QR
            light: "#FFF", // Warna background
        },
    },
    function (err) {
        if (err) throw err;
        console.log("QR code berhasil dibuat!");
    }
);
