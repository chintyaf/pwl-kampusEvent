// // middleware/auth.js
// const jwt = require('jsonwebtoken');
// const User = require('../models/User');

// const auth = async (req, res, next) => {
//   try {
//     const token = req.header('Authorization')?.replace('Bearer ', '');

//     if (!token) {
//       return res.status(401).json({ message: 'No token provided' });
//     }

//     const decoded = jwt.verify(token, process.env.JWT_SECRET);
//     const user = await User.findById(decoded.userId).select('-password');

//     if (!user || !user.isActive) {
//       return res.status(401).json({ message: 'Invalid token' });
//     }

//     req.user = user;
//     next();
//   } catch (error) {
//     res.status(401).json({ message: 'Invalid token' });
//   }
// };

// const authorize = (...roles) => {
//   return (req, res, next) => {
//     if (!req.user) {
//       return res.status(401).json({ message: 'Access denied. No user found.' });
//     }

//     if (!roles.includes(req.user.role)) {
//       return res.status(403).json({
//         message: `Access denied. Required roles: ${roles.join(', ')}`
//       });
//     }

//     next();
//   };
// };

// module.exports = { auth, authorize };

// middleware/auth.js

const jwt = require("jsonwebtoken");
const JWT_SECRET = "your_secret_key";

const auth = (req, res, next) => {
    const token = req.headers.authorization?.split(" ")[1]; // Bearer <token>
    if (!token) return res.status(401).json({ error: "No token provided" });

    try {
        const decoded = jwt.verify(token, JWT_SECRET);
        req.user = decoded;
        next();
    } catch (err) {
        return res.status(403).json({ error: "Invalid token" });
    }
};

module.exports = auth;
