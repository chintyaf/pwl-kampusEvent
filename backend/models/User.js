const mongoose = require("mongoose");

// User Schema & Model
const userSchema = new mongoose.Schema({
    name: String,
    email: String,
    password: String,
    role: {
        type: String,
        enum: [
            "guest",
            "member",
            "admin",
            "finance_team",
            "event_committee",
            "event_staff",
        ],
        default: "guest",
    },
    is_active: { type: Boolean, default: true },
    created_at: { type: Date, default: Date.now },
    updated_at: { type: Date, default: Date.now },
});

module.exports = mongoose.model("User", userSchema);
