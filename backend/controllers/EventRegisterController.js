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

// exports.register = async (req, res) => {
//     console.log(req.body);

//     const { user_id, event_id, payment_method } = req.body;
//     let sessions = [];

//     try {
//         sessions = JSON.parse(req.body.sessions); // karena dikirim dari Laravel sebagai string
//     } catch (e) {
//         return res.status(400).json({ message: "Invalid sessions format." });
//     }

//     // Validasi dasar
//     if (
//         !user_id ||
//         !event_id ||
//         !Array.isArray(sessions) ||
//         sessions.length === 0
//     ) {
//         return res
//             .status(400)
//             .json({ message: "Missing required registration data." });
//     }

//     // Ambil path file dari multer
//     const proofImageUrl = req.file ? req.file.path : null;

//     const attending_session = sessions.map((s) => ({
//         session_id: s.id,
//     }));

//     // Simpan registrasi baru
//     const eventReg = new EventRegister({
//         user_id,
//         event_id,
//         attending_session,
//         payment: {
//             method: payment_method,
//             proof_image_url: proofImageUrl,
//         },
//     });

//     // await eventReg.save();

//     const event = await Event.findById(event_id);
//     if (!event) return res.status(404).json({ message: "Event not found." });

//     let sessionModified = false;
//     for (const s of sessions) {
//         const session = event.session.find(
//             (sess) => sess._id.toString() === s.id.toString()
//         );
//         if (session) {
//             const alreadyRegistered = session.attending_user.some(
//                 (u) => u.user.toString() === user_id.toString()
//             );
//             if (!alreadyRegistered) {
//                 session.attending_user.push({
//                     user: user_id,
//                     status: "absent",
//                     certificate: {},
//                 });
//                 session.total_participants =
//                     (session.total_participants || 0) + 1;
//                 sessionModified = true;
//             }
//         } else {
//             console.warn(`Session ID ${s.id} not found in event.`);
//         }
//     }

//     // if (sessionModified) await event.save();

//     return res.status(201).json({
//         message:
//             "Successfully registered, please wait for payment confirmation.",
//         // registration_id: eventReg._id,
//     });

//     try {
//     } catch (err) {
//         console.error("Error registering for event:", err);
//         return res
//             .status(500)
//             .json({ message: "Server error during registration." });
//     }
// };

exports.register = async (req, res) => {
    try {
        console.log("Incoming Body:", req.body);

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
