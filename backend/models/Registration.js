// models/Registration.js
const mongoose = require("mongoose");

const registrationSchema = new mongoose.Schema({
    eventId: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "Event",
        required: true,
    },
    memberId: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "User",
        required: true,
    },
    memberName: {
        type: String,
        required: true,
    },
    memberEmail: {
        type: String,
        required: true,
    },
    paymentStatus: {
        type: String,
        enum: ["pending", "paid", "verified", "rejected"],
        default: "pending",
    },
    paymentProof: {
        type: String, // URL to uploaded payment proof
        default: null,
    },
    paymentAmount: {
        type: Number,
        required: true,
    },
    paymentDate: {
        type: Date,
        default: null,
    },
    verifiedBy: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "User",
        default: null,
    },
    verifiedAt: {
        type: Date,
        default: null,
    },
    notes: {
        type: String,
        default: "",
    },
    registrationDate: {
        type: Date,
        default: Date.now,
    },
    qrCode: {
        type: String,
        default: null,
    },
    attendanceStatus: {
        type: String,
        enum: ["registered", "attended"],
        default: "registered",
    },
});

module.exports = mongoose.model("Registration", registrationSchema);
