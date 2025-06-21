const express = require("express");
const router = express.Router();
const authController = require("../controllers/authController");
const eventController = require("../controllers/EventsController");
const financeController = require("../controllers/FinanceController");
const eventRegistController = require("../controllers/EventRegisterController");
const staffController = require("../controllers/StaffController");
const auths = require("../middleware/auth");

// Ini yang lama I think
// router.post("/register", authController.register);
// router.post("/login", authController.login);

router.post("/auth/register", authController.register);
router.post("/auth/login", authController.login);
router.post("/auth/login-auth", authController.loginAuth);
router.get("/auth/check", auths, authController.getAuth);

router.get("/events", eventController.view);
router.post("/events/store", eventController.store);
router.get("/events/:id", eventController.edit);
router.put("/events/:id", eventController.update);

// FINANCE
// router.put("/finance/:id", financeController.payment);

// EVENT REGISTER
// buat finance
router.get("/event-register/view-payment", financeController.view);
router.get("/event-register/view-payment/:id", financeController.viewRegister);
router.post(
    "/event-register/view-payment/:id/update",
    financeController.updatePayment
);

// Member
router.post("/member/event/register", eventRegistController.register);

// Staff
// scan QR => update
// router.get("/staff/event-register/:id/register", staffController.viewEvent);
// :id => session id
router.post("/staff/re-register", staffController.updateAttendance);

router.post("/staff/test-qr", staffController.testQR);

module.exports = router;
