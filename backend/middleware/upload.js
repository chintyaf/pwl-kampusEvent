// middleware/upload.js
const path = require("path");
const multer = require("multer");

// ✅ Konfigurasi untuk pembayaran
const paymentStorage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, "data/payments");
    },
    filename: (req, file, cb) => {
        const ext = path.extname(file.originalname);
        const uniqueName =
            Date.now() + "-" + Math.round(Math.random() * 1e9) + ext;
        cb(null, uniqueName);
    },
});
const paymentUpload = multer({ storage: paymentStorage });

// ✅ Konfigurasi untuk sertifikat
const certUpload = multer({ dest: "data/certificates/" });

module.exports = {
    paymentUpload,
    certUpload,
};
