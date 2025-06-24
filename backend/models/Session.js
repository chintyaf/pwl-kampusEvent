const mongoose = require("mongoose");
const { SpeakerSchema } = require("./Speaker");

const SessionSchema = new mongoose.Schema({
    // Event session
    title: { type: String },
    description: { type: String },
    registration_fee: { type: Number },

    // Tempat & Lokasi
    date: { type: Date },
    start_time: { type: Date },
    end_time: { type: Date },
    location: {
        type: String,
    },

    // Peserta
    max_participants: { type: Number },
    total_participants: { type: Number, default: 0 },
    attending_user: [
        {
            user: {
                type: mongoose.Schema.Types.ObjectId,
                ref: "EventRegisters",
                required: true,
            },
            status: {
                type: String,
                enum: ["absent", "present"],
                default: "absent",
            },
            certificate: {
                file_url: String,
                upload_date: Date,
            },
        },
    ],

    // Speaker
    speaker: {
        type: [SpeakerSchema],
    },
    moderator: {
        type: [SpeakerSchema],
    },
});

module.exports = { SessionSchema };
