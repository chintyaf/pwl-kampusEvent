const express = require("express");
const cors = require("cors");

const app = express();
const PORT = 3001;

app.use(
    cors({
        origin: "http://localhost:8000", // Laravel frontend origin
        credentials: true,
    })
);
app.use(express.json());

app.post("/api/login", (req, res) => {
    const { email } = req.body;

    if (!email) {
        return res.status(400).json({ error: "Email required" });
    }

    // Simulate backend login logic here
    console.log("Login request for:", email);

    // Respond with JSON — your backend logic can be much more complex
    return res.json({ email, token: "dummy-token" });
});

app.listen(PORT, () =>
    console.log(`Node.js API running on http://localhost:${PORT}`)
);
