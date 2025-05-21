const express = require("express");
const cors = require("cors");
const app = express();
const myRouter = require("./routes/myRouter");

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Use router
app.use("/", myRouter);

const PORT = 5000;
app.listen(PORT, () => {
    console.log(`Node.js backend running on http://localhost:${PORT}`);
});
