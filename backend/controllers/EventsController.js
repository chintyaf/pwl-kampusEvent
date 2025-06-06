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

// Store new event
exports.store = async (req, res) => {
    try {
        const {
            user_id,
            name,
            description,
            poster_url,
            sessions = [],
        } = req.body;

        const event = new Event({
            user_id,
            name,
            description,
            poster_url,
            session: sessions.map((s) => ({
                title: s.title,
                desc: s.desc,
                date: s.date,
                start_time: s.start_time,
                end_time: s.end_time,
                location: s.location,
                max_participants: s.max_participants,
                registration_fee: s.registration_fee,
                total_participants: 0,
                speaker: s.speaker || [],
                moderator: s.moderator || [],
            })),
        });

        console.log("This is from event");
        console.log(event);

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
