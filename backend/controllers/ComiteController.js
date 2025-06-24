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

        // Find one event that matches user_id and event_id
        const event = await Event.findOne({
            _id: event_id,
            user_id: user_id,
        }).populate("session.attending_user.user.attending_session");

        if (!event) {
            return res.status(404).json({ error: "Event not found" });
        }

        console.log(event);
        // Find the session within the event
        const session = event.session.find((s) => String(s._id) === session_id);

        if (!session) {
            return res
                .status(404)
                .json({ error: "Session not found in this event" });
        }

        res.json(session);
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: "Failed to fetch event" });
    }
};

exports.uploadCert = async (req, res) => {
    const { user_id, event_id, session_id } = req.params;

    // Find one event that matches user_id and event_id
    const event = await Event.findOne({
        _id: event_id,
        user_id: user_id,
    });

    if (!event) {
        return res.status(404).json({ error: "Event not found" });
    }

    // Find the session within the event
    const session = event.session.findOne((s) => String(s._id) === session_id);

    const zip = req.file;

    if (!zip) return res.status(400).json({ error: "No ZIP uploaded" });

    const extractPath = path.join(
        __dirname,
        "..",
        "certificates",
        `${event_id}_${session_id}`
    );
    await fs.ensureDir(extractPath);

    fs.createReadStream(zip.path)
        .pipe(unzipper.Extract({ path: extractPath }))
        .on("close", async () => {
            await fs.unlink(zip.path); // delete uploaded zip

            const files = await fs.readdir(extractPath);

            // Find the session to update
            // const session = await Session.findOne({ _id: session_id });
            if (!session)
                return res.status(404).json({ error: "Session not found" });

            let updatedCount = 0;

            for (const file of files) {
                const filePath = `/data/certificates/${event_id}_${session_id}/${file}`;
                const baseName = path.parse(file).name; // assuming baseName is user_id

                const userEntry = session.attending_user.find(
                    (att) => att.user.toString() === baseName
                );
                if (userEntry) {
                    userEntry.certificate = {
                        file_url: filePath,
                        upload_date: new Date(),
                    };
                    updatedCount++;
                }
            }

            await session.save();

            res.json({
                message: `Certificates uploaded and ${updatedCount} users updated.`,
            });
        })
        .on("error", (err) => {
            res.status(500).json({ error: "Extraction failed", details: err });
        });
};
