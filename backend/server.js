const express = require("express");
const app = express();
const mongoose = require("mongoose");
const cors = require("cors");
const bodyParser = require("body-parser");
require('dotenv').config();

// Middleware
app.use(cors());
app.use(bodyParser.json());

mongoose
    .connect("mongodb://localhost:27017/laravel_node")
    .then(() => console.log("✅ Connected to MongoDB"))
    .catch((err) => console.error("❌ MongoDB connection error:", err));

const routes = require("./routes/route");
app.use("/api", routes);

const financeRoutes = require('./routes/finance');
app.use('/api/finance', financeRoutes);

// Routes
// app.use('/api/auth', require('./routes/auth'));
// app.use('/api/admin', require('./routes/admin'));
// app.use('/api/finance', require('./routes/finance'));
// app.use('/api/events', require('./routes/events'));


// const PORT = process.env.PORT || 3000;
const PORT = 3000;
app.listen(PORT, () =>
    console.log(`Node.js backend running at http://localhost:${PORT}`)
);
