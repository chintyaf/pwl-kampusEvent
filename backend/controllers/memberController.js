const EventRegister = require("../models/EventRegister");
const Event = require("../models/Event");
const mongoose = require("mongoose");

exports.profile = async (req, res) => {
    try {
        const userId = req.params.userId;

        const eventRegister = await EventRegister.find({ user: userId });

        res.json(eventRegister);
    } catch (error) {
        res.status(500).json({ error: "Failed to fetch event register" });
    }
};

exports.registered = async (req, res) => {
    const userId = req.params.user_id;
    const registerId = req.params.register_id;
    // console.log(userId, registerId);

    const eventRegister = await EventRegister.find({
        _id: registerId,
        user_id: userId,
    });

    res.json(eventRegister);
    try {
        // const userId = req.params.userId;
        // const eventId = req.params.eventId;
        // const eventRegister = await EventRegister.find({
        //     user: mongoose.Types.ObjectId(userId),
        //     events: mongoose.Types.ObjectId(eventId),
        // });
        // res.json(eventRegister);
    } catch (error) {
        res.status(500).json({
            error: "Failed to fetch event register",
        });
    }
};
