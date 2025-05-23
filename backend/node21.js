const express = require("express");
const cors = require("cors");
const bodyParser = require("body-parser");
const mongoose = require("mongoose");
const bcrypt = require("bcrypt");

const app = express();
const PORT = 3000;

app.use(cors());
app.use(bodyParser.json());

mongoose
  .connect("mongodb://localhost:27017/laravel_node")
  .then(() => console.log("✅ Connected to MongoDB"))
  .catch((err) => console.error("❌ MongoDB connection error:", err));

const userSchema = new mongoose.Schema({
  name: String,
  email: { type: String, unique: true },
  password: String,
  role: { type: String, default: "member" } // bisa 'admin', 'user', 'staff', dll
});

const User = mongoose.model("User", userSchema);

// Register route (sama seperti sebelumnya)
app.post('/register', async (req, res) => {
    const { name, email, password } = req.body;
  
    if (!name || !email || !password) {
      return res.status(400).json({ message: "All fields are required" });
    }
  
    const existing = await User.findOne({ email });
    if (existing) return res.status(409).json({ message: "Email already registered" });
  
    const hashedPassword = password; // (Gunakan bcrypt di real case)
  
    const user = new User({
      name,
      email,
      password: hashedPassword,
      role: 'member' // otomatis jadi member
    });
  
    await user.save();
    res.json({ message: 'Registered as member successfully' });
  });
  

// Login route
app.post("/login", async (req, res) => {
  const { email, password } = req.body;

  if (!email || !password) {
    return res.status(400).json({ message: "Missing email or password" });
  }

  try {
    const user = await User.findOne({ email });
    if (!user) {
      return res.status(401).json({ message: "Invalid email or password" });
    }

    const isPasswordValid = await bcrypt.compare(password, user.password);
    if (!isPasswordValid) {
      return res.status(401).json({ message: "Invalid email or password" });
    }

    // Login berhasil, bisa tambahkan session / token di sini kalau mau

    res.json({ message: "Login successful", userId: user._id, name: user.name });
  } catch (err) {
    res.status(500).json({ message: "Error during login", error: err.message });
  }
});

app.listen(PORT, () => {
  console.log(`🚀 Server running on http://localhost:${PORT}`);
});
