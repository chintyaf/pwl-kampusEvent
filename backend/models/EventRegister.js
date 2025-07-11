const mongoose = require("mongoose");
const { AttendSession } = require("./AttendSession");

// Order Register Event
const objSchema = new mongoose.Schema({
    user_id: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "User",
        required: true,
    },
    event_id: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "Event",
        required: true,
    },
    attending_session: [AttendSession],
    payment: {
        proof_image_url: {
            type: String,
            required: true,
        },
        payment_date: {
            type: Date,
            default: Date.now,
        },
        status: {
            type: String,
            enum: ["pending", "approved", "rejected"],
            default: "pending",
        },
        method: {
            type: String,
            enum: ["bca", "mandiri", "bni", "bri"],
            required: true,
        },
    },
    created_at: { type: Date, default: Date.now },
    updated_at: { type: Date, default: Date.now },
});
exports.objSchema = objSchema;

module.exports = mongoose.model("EventRegister", objSchema);
