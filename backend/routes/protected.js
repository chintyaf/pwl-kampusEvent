// // routes/protected.js
// const express = require('express');
// const { auth, authorize } = require('../middleware/auth');

// const router = express.Router();

// // Protected route - any authenticated user
// router.get('/dashboard', auth, (req, res) => {
//   res.json({
//     message: `Welcome to dashboard, ${req.user.name}!`,
//     user: {
//       name: req.user.name,
//       role: req.user.role
//     }
//   });
// });

// // Admin only
// router.get('/admin', auth, authorize('admin'), (req, res) => {
//   res.json({
//     message: 'Admin panel access granted',
//     data: 'Secret admin data'
//   });
// });

// // Finance team only
// router.get('/finance', auth, authorize('finance_team', 'admin'), (req, res) => {
//   res.json({
//     message: 'Finance section access granted',
//     data: 'Financial reports and data'
//   });
// });

// // Event committee only
// router.get('/events', auth, authorize('event_committee', 'admin'), (req, res) => {
//   res.json({
//     message: 'Events management access granted',
//     data: 'Event management tools'
//   });
// });

// // Staff and above
// router.get('/staff', auth, authorize('staff', 'admin', 'finance_team', 'event_committee'), (req, res) => {
//   res.json({
//     message: 'Staff area access granted',
//     data: 'Staff resources and tools'
//   });
// });

// // Multiple roles example
// router.get('/members', auth, authorize('member', 'admin', 'staff'), (req, res) => {
//   res.json({
//     message: 'Members area access granted',
//     data: 'Member exclusive content'
//   });
// });

// module.exports = router;

// routes/protected.js
const express = require("express");
const router = express.Router();
const auth = require("../middleware/auth");

router.get("/profile", auth, (req, res) => {
    res.json({ message: "You are authorized", user: req.user });
});

module.exports = router;
