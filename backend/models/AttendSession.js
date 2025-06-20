const mongoose = require("mongoose");

const AttendSession = new mongoose.Schema({
    session_id: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "Events", // Reference to the Events model
        required: true,
    },
    qr_code: String,
    attendance: {
        status: {
            type: String,
            enum: ["absent", "present"],
            default: "absent",
        },
        scanned_by: {
            type: mongoose.Schema.Types.ObjectId,
            ref: "User", // Reference to event committee
        },
        scan_time: Date,
    },
    certificate: {
        file_url: String,
        upload_date: Date,
        uploaded_by: {
            type: mongoose.Schema.Types.ObjectId,
            ref: "User",
        },
    },
});

module.exports = { AttendSession };
