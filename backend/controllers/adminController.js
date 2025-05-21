// controllers/AdminController.js

const bcrypt = require("bcrypt");
const User = require("../models/User");

exports.getUsers = async (req, res) => {
    try {
        const users = await User.find({
            role: { $in: ["finance_team", "event_committee"] },
        });
        res.json(users);
    } catch (error) {
        res.status(500).json({ message: "Server error", error });
    }
};

exports.addUser = async (req, res) => {
    try {
        const { name, email, password, role } = req.body;
        const hashedPassword = await bcrypt.hash(password, 10);

        const newUser = new User({
            name,
            email,
            password: hashedPassword,
            role,
            is_active: true,
            created_at: new Date(),
            updated_at: new Date(),
        });

        await newUser.save();
        res.json({ message: "User ditambahkan" });
    } catch (error) {
        res.status(500).json({ message: "Server error", error });
    }
};

exports.updateUserStatus = async (req, res) => {
    try {
        const { id } = req.params;
        const { is_active } = req.body;

        await User.findByIdAndUpdate(id, { is_active, updated_at: new Date() });
        res.json({ message: "Status diperbarui" });
    } catch (error) {
        res.status(500).json({ message: "Server error", error });
    }
};

exports.deleteUser = async (req, res) => {
    try {
        const { id } = req.params;
        await User.findByIdAndDelete(id);
        res.json({ message: "User dihapus" });
    } catch (error) {
        res.status(500).json({ message: "Server error", error });
    }
};
