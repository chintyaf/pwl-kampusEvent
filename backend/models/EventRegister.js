const mongoose = require("mongoose");
const { AttendSession } = require("./AttendSession");

// Order Register Event
const objSchema = new mongoose.Schema({
    user_id: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "User", // Reference to the User model
        required: true,
    },
    event_id: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "Events", // Reference to the Events model
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
        verified_by: {
            type: mongoose.Schema.Types.ObjectId,
            ref: "User", // Reference to User (finance/admin)
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
