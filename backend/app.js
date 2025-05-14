// node-backend/index.js
const express = require("express");
const cors = require("cors");
const app = express();
const port = 5000;

app.use(cors()); // Allow requests from Laravel
app.use(express.json());

app.get("/api/message", (req, res) => {
    res.json({ message: "Hello from Node.js backend!" });
});

app.listen(port, () => {
    console.log(`Node.js backend running at http://localhost:${port}`);
});
