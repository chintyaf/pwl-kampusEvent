const Event = require("../models/Event");
const Session = require("../models/Session");

exports.view = async (req, res) => {
    try {
        const events = await Event.find(); // Get all events

        res.json(events); // Send JSON response
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch events" });
    }
};

exports.viewRegister = async (req, res) => {
    try {
        const events = await Event.find(); // Get all events
        res.json(events); // Send JSON response
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch events" });
    }
};

// Store new event
exports.store = async (req, res) => {
    try {
        console.log(req.body);
        const {
            user_id,
            name,
            description,
            poster_url,
            sessions = [],
        } = req.body;

        console.log("SUBMITED : ", req.body);

        const sessionDates = sessions.map((s) => new Date(s.date));

        // Find the earliest and latest dates
        const start_date = new Date(Math.min(...sessionDates));
        const end_date = new Date(Math.max(...sessionDates));

        // console.log("SESSIONS:", s.speakers, s.moderators);

        const event = new Event({
            user_id,
            name,
            description,
            start_date: start_date,
            end_date: end_date,
            poster_url,
            session: sessions.map((s) => ({
                title: s.title,
                description: s.description,
                date: s.date,
                start_time: s.start_time,
                end_time: s.end_time,
                location: s.location,
                max_participants: s.max_participants,
                registration_fee: s.registration_fee,
                total_participants: 0,
                speaker: s.speakers || [],
                moderator: s.moderators || [],
            })),
        });

        // console.log("This is from event");
        // console.log(event);

        await event.save();
        res.json({ message: "New event added successfully", event });
    } catch (error) {
        console.error("Error saving event:", error);
        res.status(500).json({ message: "Server error while saving event" });
    }
};

exports.update = async (req, res) => {
    const { id } = req.params;

    try {
        const {
            name,
            date,
            start_time,
            end_time,
            location,
            registration_fee,
            max_participants,
        } = req.body;

        // Tangani array speaker (support untuk multipart/form-data)
        let speaker = [];
        if (Array.isArray(req.body["speaker[]"])) {
            speaker = req.body["speaker[]"];
        } else if (typeof req.body["speaker[]"] === "string") {
            speaker = [req.body["speaker[]"]];
        }

        // Siapkan data yang akan diupdate
        const updateData = {
            name,
            date,
            start_time,
            end_time,
            location,
            registration_fee,
            max_participants,
            speaker,
        };

        // Tangani file poster jika diupload
        // if (req.file) {
        //     updateData.poster_url = `/uploads/${req.file.filename}`;
        // }

        const updatedEvent = await Event.findByIdAndUpdate(id, updateData, {
            new: true,
        });

        if (!updatedEvent) {
            return res.status(404).json({ message: "Event not found" });
        }

        res.json({
            message: "Event updated successfully",
            event: updatedEvent,
        });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Server error" });
    }
};

exports.edit = async (req, res) => {
    try {
        const event = await Event.findById(req.params.id);
        if (!event) {
            return res.status(404).json({ message: "Event not found" });
        }
        return res.json(event);
    } catch (error) {
        console.error("Error saving event:", error);
        res.status(500).json({ message: "Server error while saving event" });
    }
};

// Update an existing event
exports.update = async (req, res) => {
    const { id } = req.params;

    try {
        const { name, description, poster_url, total_participants } = req.body;

        const updateData = {
            name,
            description,
            poster_url,
            total_participants,
        };

        const updatedEvent = await Event.findByIdAndUpdate(id, updateData, {
            new: true,
        });

        if (!updatedEvent) {
            return res.status(404).json({ message: "Event not found" });
        }

        res.json({
            message: "Event updated successfully",
            event: updatedEvent,
        });
    } catch (err) {
        console.error("Error updating event:", err);
        res.status(500).json({ message: "Server error" });
    }
};
