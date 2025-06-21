const EventRegister = require("../models/EventRegister");

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
        const { user_id, event_id, visitors, sessions, payment } = req.body;

        if (
            !user_id ||
            !event_id ||
            !sessions ||
            !Array.isArray(sessions) ||
            sessions.length === 0
        ) {
            return res
                .status(400)
                .json({ message: "Missing required registration data." });
        }

        // 1. Build AttendSession array from sessions
        const attending_session = sessions.map((s) => ({
            session_id: s.id,
        }));

        // 2. Create new EventRegister document
        const eventReg = new EventRegister({
            user_id,
            event_id,
            attending_session,
            payment: {
                method: payment.method,
                proof_image_url: payment.proof_image_url,
                status: "pending", // optional: default already
            },
        });

        await eventReg.save();

        return res.status(201).json({
            message:
                "Successfully registered, please wait for payment confirmation.",
            registration_id: eventReg._id,
        });
    } catch (err) {
        console.error("Error registering for event:", err);
        return res
            .status(500)
            .json({ message: "Server error during registration." });
    }
};

exports.scanQR = async (req, res) => {
    // const token = req.query.token;
    // if (!token)
    //     return res.status(400).json({ message: "Token tidak ditemukan" });

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
