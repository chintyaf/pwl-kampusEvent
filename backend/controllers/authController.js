const User = require("../models/User");
const express = require("express");
const jwt = require("jsonwebtoken");
const bcrypt = require("bcryptjs");

const app = express();
app.use(express.json());

const JWT_SECRET = "your_secret_key"; // Store in env in production

exports.getAuth = async (req, res) => {
    const user = req.user;
    res.json({
        id: user._id,
        name: user.name,
        email: user.email,
        role: user.role,
    });
};

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
    // console.log(email, password);

    try {
        const user = await User.findOne({ email });

        if (!user) return res.status(401).json({ message: "User not found" });

        const validPassword = await bcrypt.compare(password, user.password);
        // console.log(validPassword);
        if (!validPassword)
            return res.status(401).json({ message: "Invalid password" });

        if (!user.is_active)
            return res.status(403).json({ message: "User is deactivated" });

        // Create JWT
        const token = jwt.sign(
            { id: user.id, email: user.email, role: user.role },
            JWT_SECRET,
            { expiresIn: "1h" }
        );

        res.status(201).json({
            message: "Login successful",
            token,
            user: {
                name: user.name,
                email: user.email,
                role: user.role,
            },
        });
        // console.log(user, token);
    } catch (error) {
        console.log(error);
        res.status(500).json({ message: "Server error", error });
    }
};

exports.loginAuth = async (req, res) => {
    const authHeader = req.headers.authorization;
    // console.log(req.headers);

    if (!authHeader || !authHeader.startsWith("Bearer ")) {
        return res.status(401).json({ error: "Token missing or invalid" });
    }

    const token = authHeader.split(" ")[1];

    try {
        // Decode & verify token
        const decoded = jwt.verify(token, JWT_SECRET);

        // Optional: Fetch user from DB to ensure they still exist and are active
        const user = await User.findById(decoded.id);

        if (!user || !user.is_active) {
            return res
                .status(403)
                .json({ error: "User not found or inactive" });
        }

        // Return user info (for Laravel)
        return res.json({
            id: user.id,
            email: user.email,
            role: user.role,
            name: user.name,
        });
    } catch (err) {
        return res.status(401).json({ error: "Token invalid or expired" });
    }
};
