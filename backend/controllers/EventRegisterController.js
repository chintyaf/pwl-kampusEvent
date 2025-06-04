const EventRegis = require("../models/EventRegister");

exports.register = async (req, res) => {
    const { user_id, event_id, visitor, registration_date, payment } = req.body;

    console.log(req.body);
    const eventReg = new EventRegis({
        // user_id,
        // event_id,
        visitor,
        registration_date,
        payment,
        status: "pending",
    });

    console.log("test");
    console.log(req.body);
    // await eventReg.save();
    res.json({
        message:
            "Successfully registered, please wait until we confirmed your payment",
    });
};
