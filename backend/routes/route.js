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
const { paymentUpload, certUpload } = require("../middleware/upload");

router.post("/auth/register", authController.register); // Register akun
router.post("/auth/login", authController.login); // Masuk akun
router.post("/auth/login-auth", authController.loginAuth); // Cek autentikasi login while on web
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
router.post(
    "/member/event/register",
    paymentUpload.single("proof_image_url"),
    eventRegistController.register
);
router.get("/member/profile/:user_id", memberController.profile);
router.get(
    "/member/profile/:user_id/registered/:register_id",
    memberController.registered
);

// STAFF --  :id => session id
// router.get("/staff/event-register/:id/register", staffController.viewEvent);
// scan QR => update
router.post("/staff/re-register", staffController.updateAttendance);

// COMITE
router.get("/comite/:user_id/events/:event_id", comiteController.viewAttendees); //
router.get(
    "/comite/:user_id/events/:event_id/:session_id",
    comiteController.viewAttendeesSession
);
router.post(
    "/comite/:user_id/events/:event_id/:session_id/uploadCert",
    certUpload.single("certificate"),
    comiteController.uploadCert
);

const UserController = require("../controllers/UserController");

router.get("/users", UserController.getAll);
router.get("/users/:id", UserController.getOne);
router.post("/users", UserController.create);
router.put("/users/:id", UserController.update);
router.delete("/users/:id", UserController.remove);

module.exports = router;
