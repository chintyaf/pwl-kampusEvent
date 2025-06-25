const EventRegister = require("../models/EventRegister");
const Event = require("../models/Event");
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

// exports.updatePayment = async (req, res) => {
//     const { id } = req.params;
//     const { status } = req.body; // status baru yang ingin diubah (approved/rejected/pending)

//     // Validasi input
//     const allowedStatus = ["pending", "approved", "rejected"];
//     if (!allowedStatus.includes(status)) {
//         return res.status(400).json({ error: "Invalid payment status" });
//     }

//     try {
//         const registration = await EventRegister.findById(id);
//         console.log("REGISTRATION :", registration, "END");
//         if (!registration) {
//             return res.status(404).json({ error: "Registration not found" });
//         }

//         registration.payment.status = status;
//         registration.updated_at = new Date();

//         if (status === "approved") {
//             // Main QR
//             const globalQRData = JSON.stringify({
//                 registration_id: registration._id,
//                 user_id: registration.user_id,
//                 event_id: registration.event_id,
//                 verified: true,
//             });

//             const qrPath = await generateQRCode(
//                 globalQRData,
//                 `reg-${registration._id}`
//             );
//             registration.qr_code = qrPath;

//             // Session QR Codes
//             const updatedSessions = await Promise.all(
//                 registration.attending_session.map(async (session) => {
//                     const sessionQRData = JSON.stringify({
//                         registration_id: registration._id,
//                         user_id: registration.user_id,
//                         event_id: registration.event_id,
//                         session_id: session.session_id,
//                         verified: true,
//                     });

//                     const sessionQRPath = await generateQRCode(
//                         sessionQRData,
//                         `sess-${session.session_id}`
//                     );
//                     session.qr_code = sessionQRPath;
//                     return session;
//                 })
//             );

//             registration.attending_session = updatedSessions;
//             // await registration.save();

//             // console.log(registration);
//             // Ambil event dan update sesi
//             const event = await Event.findOne(registration.event_id);
//             if (!event) {
//                 return res.status(404).json({ message: "Event not found." });
//             }

//             let sessionModified = false;

//             for (const s of sessions) {
//                 const session = event.session.find(
//                     (sess) => sess._id.toString() === s.id.toString()
//                 );

//                 if (session) {
//                     const alreadyRegistered = session.attending_user.some(
//                         (u) => u.user.toString() === registration._id.toString()
//                     );

//                     if (!alreadyRegistered) {
//                         session.attending_user.push({
//                             user: user_id,
//                             status: "absent",
//                             certificate: {},
//                         });

//                         session.total_participants =
//                             (session.total_participants || 0) + 1;
//                         sessionModified = true;
//                     }
//                 } else {
//                     console.warn(`⚠️ Session ID ${s.id} not found in event.`);
//                 }
//             }

//             // if (sessionModified) await event.save();
//         }
//         res.json({
//             message: "Payment status updated successfully",
//             data: registration,
//         });
//     } catch (error) {
//         console.error("Error updating payment:", error);
//         res.status(500).json({ error: "Failed to update payment status" });
//     }
// };

exports.updatePayment = async (req, res) => {
    const { id } = req.params; // id = EventRegister ID
    const { status } = req.body; // status baru

    const allowedStatus = ["pending", "approved", "rejected"];
    if (!allowedStatus.includes(status)) {
        return res.status(400).json({ error: "Invalid payment status" });
    }

    try {
        const registration = await EventRegister.findById(id);
        console.log("REGISTRATION :", registration, "END");

        if (!registration) {
            return res.status(404).json({ error: "Registration not found" });
        }

        registration.payment.status = status;
        registration.updated_at = new Date();

        if (status === "approved") {
            const user_id = registration.user_id;
            const event_id = registration.event_id;
            const sessions = registration.attending_session;

            // Main QR
            const globalQRData = JSON.stringify({
                registration_id: registration._id,
                user_id,
                event_id,
                verified: true,
            });

            const qrPath = await generateQRCode(
                globalQRData,
                `reg-${registration._id}`
            );
            registration.qr_code = qrPath;

            // Session QR
            const updatedSessions = await Promise.all(
                sessions.map(async (session) => {
                    const sessionQRData = JSON.stringify({
                        registration_id: registration._id,
                        user_id,
                        event_id,
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

            // Update Event
            const event = await Event.findById(event_id);
            if (!event) {
                return res.status(404).json({ message: "Event not found." });
            }

            let sessionModified = false;

            for (const s of sessions) {
                const session = event.session.find(
                    (sess) => sess._id.toString() === s.session_id.toString()
                );

                if (session) {
                    const alreadyRegistered = session.attending_user.some(
                        (u) => u.user.toString() === registration._id.toString()
                    );

                    if (!alreadyRegistered) {
                        session.attending_user.push({
                            user: registration._id,
                            status: "absent",
                            certificate: {},
                        });

                        session.total_participants =
                            (session.total_participants || 0) + 1;
                        sessionModified = true;
                    }
                } else {
                    console.warn(
                        `⚠️ Session ID ${s.session_id} not found in event.`
                    );
                }
            }

            if (sessionModified) await event.save();
        }

        await registration.save();

        res.json({
            message: "Payment status updated successfully",
            data: registration,
        });
    } catch (error) {
        console.error("Error updating payment:", error);
        res.status(500).json({ error: "Failed to update payment status" });
    }
};
