const User = require("../models/User");
const bcrypt = require("bcrypt");

exports.register = async (req, res) => {
    const { name, email, password } = req.body;

    if (!name || !email || !password) {
        return res.status(400).json({ message: "All fields are required" });
    }

    const existing = await User.findOne({ email });
    if (existing)
        return res.status(409).json({ message: "Email already registered" });

    // const hashedPassword = password; // (Gunakan bcrypt di real case)
    const saltRounds = 10;
    const hashedPassword = await bcrypt.hash(password, saltRounds);

    const user = new User({
        name,
        email,
        password: hashedPassword,
        role: "member", // otomatis jadi member
    });

    await user.save();
    res.json({ message: "Registered as member successfully" });
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
