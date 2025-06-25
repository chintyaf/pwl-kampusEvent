const express = require("express");
const router = express.Router();
const authController = require("../controllers/authController");
const eventController = require("../controllers/EventsController");
const eventRegistController = require("../controllers/EventRegisterController");
const { createRegistration, getAllRegistrations, updatePaymentStatus } = require('../controllers/registrationController');

// Rute untuk membuat pendaftaran baru
router.post('/registrations', createRegistration);

// Rute untuk mengambil semua pendaftaran
router.get('/registrations', getAllRegistrations);

// Rute untuk memperbarui status pembayaran
router.put('/registrations/payment-status', updatePaymentStatus);
// Ini yang lama I think
// router.post("/register", authController.register);
// router.post("/login", authController.login);

router.post("/auth/register", authController.register);
router.post("/auth/login", authController.login);
router.post("/auth/login-auth", authController.loginAuth);

router.get("/events", eventController.view);
router.post("/events/store", eventController.store);
router.get("/events/:id", eventController.edit);
router.put("/events/:id", eventController.update);

router.post("/member/event/register", eventRegistController.register);
const User = require('../models/User');

// GET all users
router.get('/users', async (req, res) => {
    try {
        const users = await User.find();
        res.json(users); // kirim seluruh data user
    } catch (error) {
        res.status(500).json({ error: 'Gagal mengambil data user' });
    }
});

module.exports = router;
