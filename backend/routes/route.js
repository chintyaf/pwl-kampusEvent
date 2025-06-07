const express = require("express");
const router = express.Router();
const authController = require("../controllers/authController");
const eventController = require("../controllers/EventsController");
const eventRegistController = require("../controllers/EventRegisterController");

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

module.exports = router;
