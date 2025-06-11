const mongoose = require("mongoose");
const bcrypt = require('bcryptjs');

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

userSchema.pre('save', async function(next) {
  if (!this.isModified('password')) return next();
  this.password = await bcrypt.hash(this.password, 10);
  next();
});

userSchema.methods.comparePassword = async function(password) {
  return await bcrypt.compare(password, this.password);
}

module.exports = mongoose.model("User", userSchema);
