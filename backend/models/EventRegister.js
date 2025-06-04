const mongoose = require("mongoose");

const objSchema = new mongoose.Schema({
    user_id: { type: mongoose.Schema.Types.ObjectId },
    event_id: { type: mongoose.Schema.Types.ObjectId },
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
    registration_date: { type: Date, default: Date.now },
    status: {
        type: String,
        enum: ["pending", "paid", "cancelled", "attended"],
        default: "pending",
    },
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
            enum: ["waiting", "approved", "rejected"],
            default: "waiting",
        },
        // verified_by: {
        //     type: mongoose.Schema.Types.ObjectId,
        //     ref: "User",
        // },
        method: {
            type: String,
            enum: ["bca", "mandiri", "bni", "bri"],
            required: true,
        },
    },
    attendance: {
        scanned_by: { type: mongoose.Schema.Types.ObjectId }, // reference to users._id (event committee)
        scan_time: Date,
    },
    certificate: {
        file_url: String,
        uploaded_by: { type: mongoose.Schema.Types.ObjectId }, // reference to users._id (event committee)
        upload_date: Date,
    },
    created_at: { type: Date, default: Date.now },
    updated_at: { type: Date, default: Date.now },
});

module.exports = mongoose.model("EventRegist", objSchema);
