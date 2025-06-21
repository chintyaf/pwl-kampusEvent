const EventRegister = require("../models/EventRegister");
const Event = require("../models/Event");

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
        const { user_id, event_id, sessions, payment } = req.body;

        // Validation
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

        // 1. Build attending_session array for EventRegister
        const attending_session = sessions.map((s) => ({
            session_id: s.id,
        }));

        // 2. Create and save new EventRegister document
        const eventReg = new EventRegister({
            user_id,
            event_id,
            attending_session,
            payment: {
                method: payment.method,
                proof_image_url: payment.proof_image_url,
            },
        });

        await eventReg.save();

        // 3. Add user to each selected session's attending_user list
        const event = await Event.findById(event_id);

        if (!event) {
            return res.status(404).json({ message: "Event not found." });
        }

        let sessionModified = false;

        for (const s of sessions) {
            // Find session by ID in event.sessions (note: should be event.sessions, not event.session)
            const session = event.session.find(
                (sess) => sess._id.toString() === s.id.toString()
            );

            if (session) {
                const alreadyRegistered = session.attending_user.some(
                    (u) => u.user.toString() === user_id.toString()
                );

                if (!alreadyRegistered) {
                    session.attending_user.push({
                        user: user_id,
                        status: "absent",
                        certificate: {}, // optional
                    });

                    session.total_participants =
                        (session.total_participants || 0) + 1;
                    sessionModified = true;
                }
            } else {
                console.warn(`Session ID ${s.id} not found in event.`);
            }
        }

        // Save event if any sessions were updated
        if (sessionModified) {
            await event.save();
        }

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
