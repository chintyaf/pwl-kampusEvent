const Event = require("../models/Event");

exports.store = async (req, res) => {
    const { user_id, event_id, visitor, registration_date, payment } = req.body;

    const event = new Event({
        user_id,
        event_id,
        visitor,
        registration_date,
        payment,
        status: "pending",
    });

    console.log("test");
    console.log(req.body);
    await event.save();
    res.json({
        message:
            "Successfully registered, please wait until we confirmed your payment",
    });
};
