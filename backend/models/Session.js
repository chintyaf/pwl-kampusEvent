const mongoose = require("mongoose");
const { SpeakerSchema } = require("./Speaker");

const SessionSchema = new mongoose.Schema({
    // Event session
    title: { type: String },
    description: { type: String },

    // Tempat & Lokasi
    date: { type: Date },
    start_time: { type: Date },
    end_time: { type: Date },
    location: {
        type: String,
    }, // smth important 4 later...

    // Peserta
    max_participants: { type: Number },
    total_participants: { type: Number, default: 0 },
    registration_fee: { type: Number },

    // Speaker
    speaker: {
        type: [SpeakerSchema],
    },
    moderator: {
        type: [SpeakerSchema],
    },
});
// exports.SessionSchema = SessionSchema;

module.exports = { SessionSchema };
// module.exports = mongoose.model("Session", SessionSchema);
