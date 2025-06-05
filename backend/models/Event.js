const mongoose = require("mongoose");
// const { ObjectId } = require("mongodb");

// User Schema & Model
const objSchema = new mongoose.Schema({
    name: String,
    date: Date,
    start_time: String,
    end_time: String,
    location: String,
    speaker: {
        type: [
            {
                name: { type: String, required: true },
                session_time: { type: String, default: "" },
            },
        ],
        default: [],
    },
    poster_url: String,
    registration_fee: Number,
    max_participants: Number,
    total_participants: Number,
    description: String,
    status: {
        type: String,
        enum: ["Upcoming", "On Going", "Finished?"],
        default: "Upcoming",
    },
    created_at: { type: Date, default: Date.now },
    updated_at: { type: Date, default: Date.now },
});

module.exports = mongoose.model("Events", objSchema);
