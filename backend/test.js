const express = require("express");
const cors = require("cors");
const app = express();

app.use(cors());
app.use(express.json());

// Simulasi data peserta
const participants = [
    { name: "Budi Santoso", token: "abc123", status: "belum_hadir" },
    { name: "Sari Dewi", token: "xyz789", status: "belum_hadir" },
];

// Endpoint verifikasi token
app.get("/verify", (req, res) => {
    const token = req.query.token;
    if (!token) return res.status(400).json({ message: "Token kosong" });

    const cleanToken = token.trim();
    const user = participants.find((p) => {
        console.log(token);
        // console.log(p.token);
        p.token === cleanToken;
    });
    if (!user)
        return res.status(404).json({ message: "Token tidak ditemukan" });

    if (user.status === "hadir") {
        return res.status(409).json({ message: "Peserta sudah hadir", user });
    }

    user.status = "hadir";
    return res.json({ message: "Check-in berhasil", user });
});

app.listen(3000, () => {
    console.log("Server running on http://localhost:3000");
});
