const express = require("express");
const cors = require("cors");
const bodyParser = require("body-parser");
const mongoose = require("mongoose");

// Create Express app
const app = express();
const PORT = 3001;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Connect to MongoDB
mongoose
    .connect("mongodb://localhost:27017/laravel_node")
    .then(() => console.log("✅ Connected to MongoDB"))
    .catch((err) => console.error("❌ MongoDB connection error:", err));

// Define User schema
const userSchema = new mongoose.Schema({
    name: String,
    email: String,
});

// Define model
const User = mongoose.model("User", userSchema);

// POST /users: Create a new user
app.post("/users", async (req, res) => {
    const { name, email } = req.body;

    if (!name || !email) {
        return res.status(400).json({ message: "Missing name or email" });
    }

    try {
        const user = new User({ name, email });
        await user.save();
        res.json({ message: "User created", user });
    } catch (err) {
        res.status(500).json({ message: "Error saving user", error: err });
    }
});

// GET /users: Get all users
app.get("/users", async (req, res) => {
    try {
        const users = await User.find();
        res.json(users);
    } catch (err) {
        res.status(500).json({ message: "Error retrieving users", error: err });
    }
});

// Start server
app.listen(PORT, () => {
    console.log(`🚀 Node.js API running at http://localhost:${PORT}`);
});
