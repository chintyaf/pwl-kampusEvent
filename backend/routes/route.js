const express = require("express");
const router = express.Router();
const authController = require("../controllers/authController");
const eventController = require("../controllers/EventsController");
const financeController = require("../controllers/FinanceController");
const eventRegistController = require("../controllers/EventRegisterController");
const staffController = require("../controllers/StaffController");
const comiteController = require("../controllers/ComiteController");
const memberController = require("../controllers/memberController");
const auths = require("../middleware/auth");

// Ini yang lama I think
// router.post("/register", authController.register);
// router.post("/login", authController.login);

router.post("/auth/register", authController.register); // Register akun
router.post("/auth/login", authController.login); // Masuk akun
router.post("/auth/login- auth", authController.loginAuth); // Cek autentikasi login while on web
router.get("/auth/check", auths, authController.getAuth); // Ngambil data user

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
router.get("/member/profile/:user_id", memberController.profile);
router.get(
    "/member/profile/:user_id/registered/:register_id",
    memberController.registered
);

// Staff
// scan QR => update
// router.get("/staff/event-register/:id/register", staffController.viewEvent);
// :id => session id
router.post("/staff/re-register", staffController.updateAttendance);

router.post("/staff/test-qr", staffController.testQR);

// MEMBER
// View attendees of an event
router.get(
    "/certificate/attendees/:event_id/:session_id",
    comiteController.viewAttendees
);

// Generate certificates for all attendees
router.post(
    "/certificate/generate/:event_id",
    comiteController.generateCertificates
);

// List generated certificates
// router.get("/certificate/list/:event_id", comiteController.listCertificates);

module.exports = router;
