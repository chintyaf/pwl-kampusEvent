const Event = require("../models/Event");

exports.view = async (req, res) => {
    try {
        const events = await Event.find(); // Get all events
        res.json(events); // Send JSON response
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch events" });
    }
};
