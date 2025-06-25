const EventRegister = require("../models/EventRegister");
const Event = require("../models/Event");
const multer = require("multer");
const upload = multer({ dest: "data/payment/" });

exports.view = async (req, res) => {
    try {
        const eventRegister = await EventRegister.find();
        res.json(eventRegister);
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch event register" });
    }
};

exports.register = async (req, res) => {
    try {
        const { user_id, event_id, payment_method } = req.body;
        let sessions = [];

        try {
            const raw = req.body.sessions;

            if (Array.isArray(raw)) {
                sessions = raw;
            } else if (typeof raw === "string") {
                // Coba parse sekali
                const firstParse = JSON.parse(raw);

                // Kalau hasil parse masih string, parse lagi
                sessions =
                    typeof firstParse === "string"
                        ? JSON.parse(firstParse)
                        : firstParse;

                if (!Array.isArray(sessions)) {
                    throw new Error("Final result is not array");
                }
            } else {
                throw new Error("Unsupported sessions format");
            }
        } catch (e) {
            console.error("❌ Failed to parse sessions:", e);
            console.error("Value of req.body.sessions:", req.body.sessions);
            return res
                .status(400)
                .json({ message: "Invalid sessions format." });
        }

        console.log("✅ Parsed sessions:", sessions);

        // Ambil path file dari multer
        const proofImageUrl = req.file ? req.file.path : null;

        // // Simpan registrasi ke DB
        const attending_session = sessions.map((s) => ({ session_id: s.id }));

        const eventReg = new EventRegister({
            user_id,
            event_id,
            attending_session,
            payment: {
                method: payment_method,
                proof_image_url: proofImageUrl,
            },
        });

        console.log(eventReg);
        await eventReg.save();

        return res.status(201).json({
            message:
                "Successfully registered, please wait for payment confirmation.",
            // registration_id: eventReg._id,
        });
    } catch (err) {
        console.error("❌ Error during registration:", err);
        return res
            .status(500)
            .json({ message: "Server error during registration." });
    }
};

exports.scanQR = async (req, res) => {
    const token = req.query.token;
    if (!token)
        return res.status(400).json({ message: "Token tidak ditemukan" });

    const user = await db.collection("participants").findOne({ token });

    if (!user) {
        return res.status(404).json({ message: "Token tidak valid" });
    }

    if (user.status === "hadir") {
        return res.status(409).json({ message: "Peserta sudah check-in" });
    }

    await db
        .collection("participants")
        .updateOne(
            { token },
            { $set: { status: "hadir", checked_in_at: new Date() } }
        );

    return res.status(200).json({
        message: "Check-in berhasil",
        user: {
            name: user.name,
            user_id: user.user_id,
        },
    });
};
