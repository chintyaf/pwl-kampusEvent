const EventRegister = require("../models/EventRegister");
const Event = require("../models/Event");
const mongoose = require("mongoose");

exports.profile = async (req, res) => {
    try {
        const userId = req.params.user_id;

        const eventRegister = await EventRegister.find({
            user_id: userId,
        }).populate(
            "event_id",
            "name start_date end_date status session attending_user"
        );

        console.log(userId, eventRegister);
        res.json(eventRegister);
    } catch (error) {
        console.error("❌ Failed to fetch event register:", error.message); // tambahkan log ini
        return res.status(500).json({
            error: "Failed to fetch event register",
            details: error.message, // tambahkan kalau ingin debug lebih cepat
        });
    }
};

exports.registered = async (req, res) => {
    try {
        const userId = req.params.user_id;
        const registerId = req.params.register_id;

        const eventRegister = await EventRegister.findOne({
            _id: registerId,
            user_id: userId,
        }).populate("event_id");

        const sessions = eventRegister.attending_session.map((att) => {
            const sessionDetail = eventRegister.event_id.session.find(
                (sess) => {
                    sess._id.toString() === att.session_id.toString();
                }
            );
            return {
                session_id: att.session_id,
                session_title: sessionDetail?.title || "Unknown",
                status: att.status,
                qr_code: att.qr_code,
            };
        });
        console.log(eventRegister);

        res.json({
            eventRegister,
            sessions,
        });
    } catch (error) {
        res.status(500).json({
            error: "Failed to fetch event register",
        });
    }
};
