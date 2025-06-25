const jwt = require("jsonwebtoken");
const JWT_SECRET = "your_secret_key";
const User = require("../models/User"); // pastikan path-nya benar

const auth = async (req, res, next) => {
    const token = req.headers.authorization?.split(" ")[1]; // Bearer <token>
    if (!token) return res.status(401).json({ error: "No token provided" });

    try {
        const decoded = jwt.verify(token, JWT_SECRET);
        const user = await User.findById(decoded.id);

        if (!user || !user.is_active) {
            return res
                .status(403)
                .json({ error: "User not found or inactive" });
        }
        console.log("Hallo");
        req.user = user; // <--- user lengkap dari database
        next();
    } catch (err) {
        return res.status(403).json({ error: "Invalid token" });
    }
};

module.exports = auth;
