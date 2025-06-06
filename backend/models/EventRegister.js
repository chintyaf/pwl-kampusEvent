const mongoose = require("mongoose");

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
    visitor: {
        type: [
            {
                name: { type: String, required: true },
                email: { type: String, required: true },
                phone_num: { type: String, required: true },
                status: {
                    type: String,
                    enum: ["belum_hadir", "hadir"],
                    default: "belum_hadir",
                },
            },
        ],
        default: [],
    },
    registration_date: { type: Date, default: Date.now },
    qr_code: String,
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
    attendance: {
        scanned_by: {
            type: mongoose.Schema.Types.ObjectId,
            ref: "User", // Reference to event committee
        },
        scan_time: Date,
    },
    certificate: {
        file_url: String,
        upload_date: Date,
        // uploaded_by: { type: mongoose.Schema.Types.ObjectId, ref: "User" }, // optional
    },
    created_at: { type: Date, default: Date.now },
    updated_at: { type: Date, default: Date.now },
});
exports.objSchema = objSchema;

module.exports = mongoose.model("EventRegister", objSchema);
