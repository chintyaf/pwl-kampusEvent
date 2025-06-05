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

exports.scanQR = async (req, res) => {
    // const token = req.query.token;
    // if (!token)
    //     return res.status(400).json({ message: "Token tidak ditemukan" });

    const user = await db.collection("participants").findOne({ token });

    if (!user) {
        return res.status(404).json({ message: "Token tidak valid" });
    }

    if (user.status === "hadir") {
        return res.status(409).json({ message: "Peserta sudah check-in" });
    }

    await db
        .collection("participants")
        .updateOne(
            { token },
            { $set: { status: "hadir", checked_in_at: new Date() } }
        );

    return res.status(200).json({
        message: "Check-in berhasil",
        user: {
            name: user.name,
            user_id: user.user_id,
        },
    });
};
