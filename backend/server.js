const express = require("express");
const app = express();
const mongoose = require("mongoose");
const cors = require("cors");
const bodyParser = require("body-parser");

// Middleware
app.use(cors());
app.use(bodyParser.json());

mongoose
    .connect("mongodb://localhost:27017/evoria")
    .then(() => console.log("✅ Connected to MongoDB"))
    .catch((err) => console.error("❌ MongoDB connection error:", err));
const routes = require("./routes/route");
app.use("/api", routes);

// const PORT = process.env.PORT || 3000;
const PORT = 3000;
app.listen(PORT, () =>
    console.log(`Node.js backend running at http://localhost:${PORT}`)
);
