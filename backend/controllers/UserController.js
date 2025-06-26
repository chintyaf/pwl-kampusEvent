const User = require("../models/User");
const bcrypt = require("bcrypt");

// GET /api/users
exports.getAll = async (req, res) => {
    try {
        const { role, status, search } = req.query;

        const query = {};

        if (role) query.role = role;
        if (status) query.is_active = status === "active";
        if (search) {
            query.$or = [
                { name: { $regex: search, $options: "i" } },
                { email: { $regex: search, $options: "i" } }
            ];
        }

        const users = await User.find(query).sort({ createdAt: -1 });

        res.json(users);
    } catch (err) {
        console.error("Get users error:", err);
        res.status(500).json({ message: "Server error" });
    }
};

// GET /api/users/:id
exports.getOne = async (req, res) => {
    try {
        const user = await User.findById(req.params.id);
        if (!user) return res.status(404).json({ message: "User not found" });
        res.json(user);
    } catch (err) {
        res.status(500).json({ message: "Server error" });
    }
};

// POST /api/users
exports.create = async (req, res) => {
    try {
        const { name, email, password, role, is_active } = req.body;

        if (!password) {
            return res.status(400).json({ message: "Password is required" });
        }

        const hashed = await bcrypt.hash(password, 10);

        const user = new User({
            name,
            email,
            password: hashed,
            role,
            is_active
        });

        await user.save();
        res.status(201).json({ message: "User created" });
    } catch (err) {
        console.error("Create user error:", err);
        res.status(500).json({ message: "Server error" });
    }
};

// PUT /api/users/:id
exports.update = async (req, res) => {
    try {
        const { name, email, password, role, is_active } = req.body;

        const updateData = { name, email, role, is_active };

        if (password) {
            updateData.password = await bcrypt.hash(password, 10);
        }

        const user = await User.findByIdAndUpdate(req.params.id, updateData, { new: true });
        if (!user) return res.status(404).json({ message: "User not found" });

        res.json({ message: "User updated" });
    } catch (err) {
        console.error("Update user error:", err);
        res.status(500).json({ message: "Server error" });
    }
};

// DELETE /api/users/:id
exports.remove = async (req, res) => {
    try {
        const user = await User.findByIdAndDelete(req.params.id);
        if (!user) return res.status(404).json({ message: "User not found" });
        res.json({ message: "User deleted" });
    } catch (err) {
        res.status(500).json({ message: "Server error" });
    }
};
