const mongoose = require("mongoose");
const { AttendSession } = require("./AttendSession");

const EventVisitorSchema = new mongoose.Schema({
    name: { type: String, required: true },
    email: { type: String, required: true },
    phone_num: { type: String, required: true },
    attending_session: [AttendSession],
});

module.exports = { EventVisitorSchema };
