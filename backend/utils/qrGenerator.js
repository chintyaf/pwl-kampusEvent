const QRCode = require("qrcode");
const fs = require("fs");
const path = require("path");

// / Ensure directory exists
const QR_DIR = path.join(__dirname, "..", "data", "qr-code");
if (!fs.existsSync(QR_DIR)) {
    fs.mkdirSync(QR_DIR, { recursive: true });
}

exports.generateQRCode = async (data, filenamePrefix = "qr") => {
    try {
        const fileName = `${filenamePrefix}-${Date.now()}.png`;
        const filePath = path.join(QR_DIR, fileName);

        await QRCode.toFile(filePath, data);

        console.log("Hallo");
        // Return relative or public URL path
        return `/data/qr-code/${fileName}`;
    } catch (error) {
        console.error("QR generation error:", error);
        throw new Error("Failed to generate QR code");
    }
};
