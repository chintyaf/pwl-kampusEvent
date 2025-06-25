const express = require("express");
const router = express.Router();
const Registration = require("../models/Registration");

// Route untuk mendapatkan daftar registrasi
router.get("/finance/registrations", async (req, res) => {
    try {
        const registrations = await Registration.find()
            .populate("eventId", "name")
            .populate("memberId", "name email");
        res.status(200).json(registrations);
    } catch (err) {
        res.status(500).json({ message: "Server error", error: err });
    }
});

// Route untuk memperbarui status pembayaran
router.put("/finance/registration/:id/status", async (req, res) => {
    const { paymentStatus, paymentProof } = req.body;
    try {
        const registration = await Registration.findById(req.params.id);
        if (!registration) {
            return res.status(404).json({ message: "Registration not found" });
        }
        registration.paymentStatus = paymentStatus;
        registration.paymentProof = paymentProof || registration.paymentProof;
        await registration.save();
        res.status(200).json({ message: "Payment status updated successfully" });
    } catch (err) {
        res.status(500).json({ message: "Server error", error: err });
    }
});

module.exports = router;
