const Event = require("../models/Event");
const EventRegister = require("../models/EventRegister");
const User = require("../models/User");
const path = require("path");
const fs = require("fs-extra");
const unzipper = require("unzipper");

exports.viewAttendees = async (req, res) => {
    try {
        const { user_id, event_id } = req.params;

        const event = await Event.find({
            _id: event_id,
            user_id: user_id,
        });
        res.json(event);
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch event" });
    }
};

exports.viewAttendeesSession = async (req, res) => {
    try {
        const { user_id, event_id, session_id } = req.params;

        const event = await Event.findOne({
            _id: event_id,
            user_id: user_id,
        }).populate({
            path: "session.attending_user.user", // populate EventRegister
            populate: {
                path: "user_id", // populate Users dari EventRegister
                model: "User",
            },
        });

        const session = event.session.find((s) => String(s._id) === session_id);

        session.attending_user.forEach((att) => {
            const register = att.user; // now a populated EventRegister
            const user = register?.user_id; // now a populated User

            if (!register || !user) return;

            // console.log({
            //     user_id: user._id,
            //     name: user.name,
            //     email: user.email,
            //     status: att.status,
            // });
        });

        // console.log(session);

        res.json({ event: event, session: session });
    } catch (error) {
        console.error("Error in viewAttendeesSession:", error);
        res.status(500).json({
            error: "Failed to fetch event session attendees",
        });
    }
};

exports.uploadCert = async (req, res) => {
    try {
        if (!req.file) {
            return res.status(400).json({ message: "No file uploaded" });
        }

        const zipPath = req.file.path;
        const extractDir = `data/certificates/${Date.now()}`;
        await fs.ensureDir(extractDir);

        const zipStream = fs
            .createReadStream(zipPath)
            .pipe(unzipper.Extract({ path: extractDir }));

        zipStream.on("close", async () => {
            try {
                const files = await fs.readdir(extractDir);
                const pdfFiles = files.filter((f) => f.endsWith(".pdf"));

                const metadata = pdfFiles.map((filename) => {
                    const base = path.basename(filename, ".pdf");
                    return {
                        file: filename,
                        eventId: base, // file format: eventRegisterId.pdf
                    };
                });

                // Populate event and session
                const event = await Event.findById(
                    req.params.event_id
                ).populate("session.attending_user");

                if (!event) {
                    return res.status(404).json({ message: "Event not found" });
                }

                const session = event.session.find(
                    (s) => String(s._id) === req.params.session_id
                );

                if (!session) {
                    return res
                        .status(404)
                        .json({ message: "Session not found" });
                }

                let updatedCount = 0;
                console.log(session);
                for (const cert of metadata) {
                    const attendee = session.attending_user.find((att) => {
                        const match = String(att.user._id) === cert.eventId;
                        console.log(
                            "Attendee ID:",
                            String(att.user._id),
                            "| Cert Event ID:",
                            cert.eventId,
                            "| Match:",
                            match
                        );
                        return match;
                    });
                    console.log(attendee);

                    if (attendee) {
                        // attendee.certificate_url = `${extractDir}/${cert.file}`;
                        const idx = session.attending_user.findIndex(
                            (att) => String(att.user._id) === cert.eventId
                        );
                        if (idx !== -1) {
                            session.attending_user[
                                idx
                            ].certificate_url = `${extractDir}/${cert.file}`;
                            updatedCount++;
                        } else {
                            console.warn(
                                `⚠️ User ${cert.eventId} not found in session`
                            );
                        }
                        console.log("ETST", attendee.certificate_url);
                    } else {
                        console.warn(
                            `⚠️ User ${cert.eventId} not found in session`
                        );
                    }
                    console.log("certif", attendee);
                }
                // console.log("AKHIR?:", event);
                await event.save();
                await fs.unlink(zipPath); // remove original zip

                return res.json({
                    message: `Uploaded ${pdfFiles.length} certificates. ${updatedCount} matched & updated.`,
                    details: metadata,
                });
            } catch (err) {
                console.error("Post-extract error:", err);
                return res.status(500).json({
                    message: "Error processing extracted files.",
                });
            }
        });

        zipStream.on("error", async (err) => {
            console.error("Unzip failed:", err);
            await fs.unlink(zipPath); // Cleanup
            return res
                .status(500)
                .json({ message: "Failed to extract zip file." });
        });
    } catch (err) {
        console.error("Outer catch:", err);
        return res
            .status(500)
            .json({ message: "Error processing ZIP upload." });
    }
};
