const EventRegister = require("../models/EventRegister");
const { generateQRCode } = require("../utils/qrGenerator");

exports.view = async (req, res) => {
    try {
        const eventRegister = await EventRegister.find();

        res.json(eventRegister);
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch event register" });
    }
};

exports.viewRegister = async (req, res) => {
    const { id } = req.params;

    try {
        const registration = await EventRegister.findById(id)
            .populate("user_id", "name email") // Tampilkan nama & email user
            .populate("event_id", "title date") // Tampilkan judul & tanggal event
            .populate("payment.verified_by", "name"); // Siapa yang verifikasi (admin)

        if (!registration) {
            return res.status(404).json({ error: "Registration not found" });
        }

        res.json(registration);
    } catch (error) {
        console.error("Error fetching registration:", error);
        res.status(500).json({ error: "Failed to fetch registration details" });
    }
};

exports.updatePayment = async (req, res) => {
    const { id } = req.params;
    const { status } = req.body; // status baru yang ingin diubah (approved/rejected/pending)

    // Asumsikan ID admin/finance yang memverifikasi dikirim via session atau middleware
    // const verifiedBy = req.user && req.user._id; // contoh: dari token login

    // Validasi input
    const allowedStatus = ["pending", "approved", "rejected"];
    if (!allowedStatus.includes(status)) {
        return res.status(400).json({ error: "Invalid payment status" });
    }

    try {
        const registration = await EventRegister.findById(id);
        if (!registration) {
            return res.status(404).json({ error: "Registration not found" });
        }

        registration.payment.status = status;
        // registration.payment.verified_by = verifiedBy;
        registration.updated_at = new Date();

        await registration.save();

        if (status === "approved") {
            // Main QR
            const globalQRData = JSON.stringify({
                registration_id: registration._id,
                user_id: registration.user_id,
                event_id: registration.event_id,
                verified: true,
            });

            const qrPath = await generateQRCode(
                globalQRData,
                `reg-${registration._id}`
            );
            registration.qr_code = qrPath;

            // Session QR Codes
            const updatedSessions = await Promise.all(
                registration.attending_session.map(async (session) => {
                    const sessionQRData = JSON.stringify({
                        registration_id: registration._id,
                        user_id: registration.user_id,
                        event_id: registration.event_id,
                        session_id: session.session_id,
                        verified: true,
                    });

                    const sessionQRPath = await generateQRCode(
                        sessionQRData,
                        `sess-${session.session_id}`
                    );
                    session.qr_code = sessionQRPath;
                    return session;
                })
            );

            registration.attending_session = updatedSessions;
        }
        res.json({
            message: "Payment status updated successfully",
            data: registration,
        });
    } catch (error) {
        console.error("Error updating payment:", error);
        res.status(500).json({ error: "Failed to update payment status" });
    }
};
