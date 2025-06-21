const EventRegister = require("../models/EventRegister");

exports.updateAttendance = async (req, res) => {
    const { registration_id, user_id, event_id, session_id } = req.body;
    // const scannedBy = req.user && req.user._id; // must be a committee/admin
    // const scannedBy = req.user && req.user._id; // must be a committee/admin

    if (!registration_id || !user_id || !event_id || !session_id) {
        return res.status(400).json({ error: "Missing required data" });
    }

    try {
        // Find the registration
        const registration = await EventRegister.findOne({
            _id: registration_id,
            user_id: user_id,
            event_id: event_id,
        });

        if (!registration) {
            return res.status(404).json({ error: "Registration not found" });
        }

        // Find the session within attending_session array
        const session = registration.attending_session.find(
            (s) => s.session_id.toString() === session_id
        );

        if (!session) {
            return res
                .status(404)
                .json({ error: "Session not found in registration" });
        }

        // Check if already present
        if (session.attendance.status === "present") {
            return res.json({
                message: "Attendance already marked",
                session,
            });
            // return res.status(400).json({ error: "Attendance already marked" });
        }

        // Update attendance
        session.attendance.status = "present";
        // session.attendance.scanned_by = scannedBy;
        session.attendance.scan_time = new Date();

        registration.updated_at = new Date();
        await registration.save();

        return res.json({
            message: "Attendance updated successfully",
            session,
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
