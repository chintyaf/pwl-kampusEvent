const User = require("../models/User");
// const bcrypt = require("bcrypt");

// exports.register = async (req, res) => {
//     console.log("Hallo m");

//     const { name, email, password, role } = req.body;

//     // if (!name || !email || !password) {
//     //     return res.status(400).json({ message: "All fields are required" });
//     // }

//     // const existing = await User.findOne({ email });
//     // if (existing)
//     //     return res.status(409).json({ message: "Email already registered" });

//     const saltRounds = 10;
//     const hashedPassword = await bcrypt.hash(password, saltRounds);

//     const user = new User({
//         name,
//         email,
//         password: hashedPassword,
//         role,
//     });

//     await user.save();
//     res.json({ message: "Registered successfully" });
// };

const express = require("express");
const jwt = require("jsonwebtoken");
const bcrypt = require("bcryptjs");

const app = express();
app.use(express.json());

const users = []; // Example in-memory storage, replace with DB

const JWT_SECRET = "your_secret_key"; // Store in env in production

exports.register = async (req, res) => {
    const { name, email, password, role } = req.body;

    // Validate required fields (simplified)
    if (!name || !email || !password || !role) {
        return res.status(400).json({ message: "Missing required fields" });
    }

    // Check if user already exists
    // const userExists = User.findOne((user) => user.email === email);
    // if (userExists) {
    //     return res.status(409).json({ message: "User already exists" });
    // }

    // Hash password
    const hashedPassword = await bcrypt.hash(password, 10);

    // Save user (replace with DB logic)
    const user = new User({
        // id: users.length + 1,
        name,
        email,
        password: hashedPassword,
        role,
    });

    await user.save();

    // Create JWT
    const token = jwt.sign(
        { id: user.id, email: user.email, role: user.role },
        JWT_SECRET,
        { expiresIn: "1h" }
    );

    res.status(201).json({
        message: "User registered successfully",
        token,
        user: {
            // id: user.id,
            name: user.name,
            email: user.email,
            role: user.role,
        },
    });
};

exports.login = async (req, res) => {
    const { email, password } = req.body;
    console.log(email, password);

    try {
        const user = await User.findOne({ email });

        if (!user) return res.status(401).json({ message: "User not found" });

        const validPassword = await bcrypt.compare(password, user.password);
        console.log(validPassword);
        if (!validPassword)
            return res.status(401).json({ message: "Invalid password" });

        if (!user.is_active)
            return res.status(403).json({ message: "User is deactivated" });

        res.json({
            message: "Login successful",
            user: {
                name: user.name,
                email: user.email,
                role: user.role,
            },
        });
    } catch (error) {
        res.status(500).json({ message: "Server error", error });
    }
};
