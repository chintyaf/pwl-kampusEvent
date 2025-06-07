const express = require("express");
const router = express.Router();
const authController = require("../controllers/AuthController");
const eventController = require("../controllers/EventsController");
const eventRegistController = require("../controllers/EventRegisterController");

// Ini yang lama I think
// router.post("/register", authController.register);
// router.post("/login", authController.login);

router.post("/auth/register", authController.register);
// router.post("/login", authController.login);

router.get("/events", eventController.view);
router.post("/events/store", eventController.store);
router.get("/events/:id", eventController.edit);
router.put("/events/:id", eventController.update);

router.post("/member/event/register", eventRegistController.register);

module.exports = router;
