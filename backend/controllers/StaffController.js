const EventRegister = require("../models/EventRegister");
const Event = require("../models/Event");
// const Session = require("../models/Session");

exports.updateAttendance = async (req, res) => {
    // console.log("HAIIIII");
    const { registration_id, user_id, event_id, session_id } = req.body;

    if (!registration_id || !user_id || !event_id || !session_id) {
        return res.status(400).json({ error: "Missing required data" });
    }

    try {
        // 1. Find the event registration
        const registration = await EventRegister.findOne({
            _id: registration_id,
            user_id,
            event_id,
        });

        if (!registration) {
            return res.status(404).json({ error: "Registration not found" });
        }

        // 2. Find the session in the registration
        const sessionReg = registration.attending_session.find(
            (s) => s.session_id.toString() === session_id
        );

        if (!sessionReg) {
            return res
                .status(404)
                .json({ error: "Session not found in registration" });
        }

        // 3. Check if already marked present
        if (sessionReg.attendance?.status === "present") {
            return res.json({
                message: "Attendance already marked",
                session: sessionReg,
            });
        }

        // 4. Update attendance in EventRegister
        sessionReg.status = "present";
        console.log(registration);
        await registration.save();

        // 5. Also update attendance in Event.sessions.attending_user
        console.log(event_id);
        const event = await Event.findById(event_id);
        if (!event) {
            return res.status(404).json({ error: "Event not found" });
        }

        const session = event.session.find(
            (s) => s._id.toString() === session_id
        );
        if (!session) {
            return res
                .status(404)
                .json({ error: "Session not found in event" });
        }

        const attendee = session.attending_user.find(
            (a) => a.user.toString() === user_id
        );

        if (!attendee) {
            return res
                .status(404)
                .json({ error: "User not registered in this session" });
        }

        attendee.status = "present";
        attendee.scan_time = new Date();
        await event.save();

        return res.json({
            message: "Attendance updated successfully",
            session: sessionReg,
        });
    } catch (error) {
        console.error("Error updating attendance:", error);
        return res.status(500).json({ error: "Failed to update attendance" });
    }
};

exports.testQR = async (req, res) => {
    const token = req.body;
    console.log(token);
    return res.json({ message: "Check-in berhasil" });
};
