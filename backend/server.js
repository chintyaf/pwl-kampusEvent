const express = require("express");
const app = express();
const mongoose = require("mongoose");
const cors = require("cors");
const bodyParser = require("body-parser");
const path = require("path");
// const userRoutes = require("./routes/userRoutes");
// app.use("/api", userRoutes);

app.use(
    "/data/qr-code",
    express.static(path.join(__dirname, "data", "qr-code"))
);

app.use(
    "/data/certificates",
    express.static(path.join(__dirname, "data", "certificates"))
);

// Serve public folder
app.use("/files", express.static(path.join(__dirname, "data")));

app.use("/data/cert", express.static(path.join(__dirname, "data", "cert")));

// Middleware
app.use(
    cors({
        origin: "*",
        allowedHeaders: ["Content-Type", "Authorization"],
    })
);
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
