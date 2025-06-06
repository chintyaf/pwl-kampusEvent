const mongoose = require("mongoose");
const { SessionSchema } = require("./Session");

const objSchema = new mongoose.Schema(
    {
        // Akun yang buat event + responsible for it
        user_id: {
            type: mongoose.Schema.Types.ObjectId,
            ref: "User", // Reference to the User model
            required: true,
        },

        // Event secara keseluruhan
        name: { type: String, required: true },
        description: { type: String, required: true },
        start_date: { type: Date },
        end_date: { type: Date },
        poster_url: { type: String },
        status: {
            type: String,
            enum: ["Upcoming", "On Going", "Finished?"],
            default: "Upcoming",
        },

        // Ngatur sesi
        session: [SessionSchema],
    },
    { timestamps: true }
);
exports.objSchema = objSchema;

module.exports = mongoose.model("Events", objSchema);
