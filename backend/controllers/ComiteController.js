const fs = require("fs");
const path = require("path");
const { PDFDocument, StandardFonts, rgb } = require("pdf-lib");
const Event = require("../models/Event");
const EventRegister = require("../models/EventRegister");
// const session = require("../models/Session");
const User = require("../models/User");

exports.viewAttendees = async (req, res) => {
    const { event_id, session_id } = req.params;

    // 1. Cari Event
    const event = await Event.findById(event_id);
    if (!event) return res.status(404).json({ message: "Event not found" });

    // 2. Cari Session
    const session = event.session.find((s) => s._id.toString() === session_id);
    if (!session) return res.status(404).json({ message: "Session not found" });

    const attended_list = session.attending_user;
    // console.log(session);
    // console.log(attended_list);

    // 3. Extract EventRegister IDs from attending_user
    const registerIds = session.attending_user.map((u) => u.user);

    // console.log(registerIds);

    // 4. Populate EventRegister + user + session
    const registrations = await EventRegister.find({
        _id: { $in: registerIds },
    })
        .populate("event_id", "name description") // populate event info
        .populate("user_id", "name email") // populate user info
        .populate("attending_session", "name") // populate session info
        .exec();

    console.log("REGISTER:", registrations);

    console.log("IDK:");
    // I REALLY DON"T KNOWWW
    // JADI AKU MAU MANGGIL INI GAHH
    // 5. Map results
    const attendees = registrations.map((reg) => {
        console.log(reg.attending_session);
        ses = reg.attending_session;
        ses.forEach((s) => {
            sessionInfo = reg.attending_session.find(
                (s) => s.session && s.session._id.toString() === session_id
            );
        });

        // return {
        //     user: reg.user, // populated user
        //     session: sessionInfo?.session, // populated session object
        //     status: sessionInfo?.status,
        //     certificate: sessionInfo?.certificate,
        // };
    });

    res.json({ attendees });
};

exports.generateCertificates = async (req, res) => {
    try {
        const { event_id } = req.params;

        const registrations = await Registration.find({
            event_id,
            attended: true,
        }).populate("user_id");
        if (registrations.length === 0)
            return res.status(404).json({ message: "No attendees found." });

        const certDir = path.join(__dirname, "..", "data", "cert", event_id);
        if (!fs.existsSync(certDir)) fs.mkdirSync(certDir, { recursive: true });

        const templatePath = path.join(
            __dirname,
            "..",
            "templates",
            "cert_template.pdf"
        );
        const templateBytes = fs.readFileSync(templatePath);

        for (const reg of registrations) {
            const name = reg.user_id.name;
            const pdfDoc = await PDFDocument.load(templateBytes);
            const page = pdfDoc.getPages()[0];

            const font = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
            page.drawText(name, {
                x: 250,
                y: 300,
                size: 24,
                font,
                color: rgb(0, 0, 0),
            });

            const pdfBytes = await pdfDoc.save();
            const filename = `${name.replace(/ /g, "_")}.pdf`;
            fs.writeFileSync(path.join(certDir, filename), pdfBytes);
        }

        res.json({
            message: "Certificates generated",
            total: registrations.length,
        });
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: "Failed to generate certificates" });
    }
};

// exports.listCertificates = async (req, res) => {
//     try {
//         const { event_id } = req.params;
//         const certDir = path.join(__dirname, "..", "data", "cert", event_id);

//         if (!fs.existsSync(certDir))
//             return res.status(404).json({ message: "No certificates found" });

//         const files = fs.readdirSync(certDir);
//         const certs = files.map((file) => ({
//             filename: file,
//             url: `/data/cert/${event_id}/${file}`,
//         }));

//         res.json({ event_id, certificates: certs });
//     } catch (err) {
//         console.error(err);
//         res.status(500).json({ error: "Failed to list certificates" });
//     }
// };
