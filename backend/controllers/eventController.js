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
