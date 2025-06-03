const Event = require("../models/Event");

exports.view = async (req, res) => {
    try {
        const events = await Event.find(); // Get all events
        res.json(events); // Send JSON response
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch events" });
    }
};

exports.store = async (req, res) => {
    const {
        name,
        date,
        start_time,
        end_time,
        location,
        speaker,
        poster_url,
        registration_fee,
        max_participants,
    } = req.body;

    const event = new Event({
        name,
        date,
        start_time,
        end_time,
        location,
        speaker,
        poster_url,
        registration_fee,
        max_participants,
        total_participants: 0,
    });

    console.log("test");
    console.log(req.body);
    await event.save();
    res.json({ message: "New event added successfully" });
};

exports.edit = async (req, res) => {
    try {
        const event = await Event.findById(req.params.id);
        if (!event) return res.status(404).json({ message: "Event not found" });
        res.json(event);
    } catch (error) {
        res.status(500).json({ message: "Server error" });
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
