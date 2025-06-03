const mongoose = require("mongoose");

const objSchema = new mongoose.Schema({
    user_id: ObjectId,
    event_id: ObjectId,
    visitor: {
        type: [
            {
                name: { type: String, required: true },
                email: { type: String, required: true },
                phone_num: { type: String, required: true },
            },
        ],
        default: [],
    },
    registration_date: Date,
    status: "pending" | "paid" | "cancelled" | "attended",
    qr_code: String,
    payment: {
        proof_image_url: String,
        payment_date: Date,
        status: "waiting" | "approved" | "rejected",
        verified_by: ObjectId, // reference to users._id (finance team)
    },
    attendance: {
        scanned_by: ObjectId, // reference to users._id (event committee)
        scan_time: Date,
    },
    certificate: {
        file_url: String,
        uploaded_by: ObjectId, // reference to users._id (event committee)
        upload_date: Date,
    },
    created_at: { type: Date, default: Date.now },
    updated_at: { type: Date, default: Date.now },
});

module.exports = mongoose.model("Event", objSchema);
