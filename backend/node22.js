const express = require("express");
const mongoose = require("mongoose");
const cors = require("cors");
const bodyParser = require("body-parser");
const bcrypt = require("bcryptjs");

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// MongoDB connection
mongoose.connect("mongodb://localhost:27017/laravel_node", {
  useNewUrlParser: true,
  useUnifiedTopology: true,
})
.then(() => console.log("✅ MongoDB connected"))
.catch(err => console.error("❌ MongoDB connection error:", err));

// User Schema & Model
const userSchema = new mongoose.Schema({
  name: String,
  email: String,
  password: String,
  role: {
    type: String,
    enum: ["guest", "member", "admin", "finance_team", "event_committee", "event_staff"],
    default: "guest"
  },
  is_active: { type: Boolean, default: true },
  created_at: { type: Date, default: Date.now },
  updated_at: { type: Date, default: Date.now }
});

const User = mongoose.model("User", userSchema);

// -------------------- ROUTES --------------------

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

// Login endpoint
app.post("/login", async (req, res) => {
  const { email, password } = req.body;

  try {
    const user = await User.findOne({ email });

    if (!user) return res.status(401).json({ message: "User not found" });

    const validPassword = await bcrypt.compare(password, user.password);
    if (!validPassword) return res.status(401).json({ message: "Invalid password" });

    if (!user.is_active) return res.status(403).json({ message: "User is deactivated" });

    res.json({
      message: "Login successful",
      user: {
        name: user.name,
        email: user.email,
        role: user.role
      }
    });

  } catch (error) {
    res.status(500).json({ message: "Server error", error });
  }
});

// Get users with finance_team or event_committee roles (for admin)
app.get('/admin/users', async (req, res) => {
  try {
    const users = await User.find({
      role: { $in: ['finance_team', 'event_committee'] }
    });
    res.json(users);
  } catch (error) {
    res.status(500).json({ message: "Server error", error });
  }
});

// Add new user (finance_team / event_committee)
app.post('/admin/users', async (req, res) => {
  try {
    const { name, email, password, role } = req.body;
    const hashedPassword = await bcrypt.hash(password, 10);

    const newUser = new User({
      name,
      email,
      password: hashedPassword,
      role,
      is_active: true,
      created_at: new Date(),
      updated_at: new Date()
    });

    await newUser.save();
    res.json({ message: 'User ditambahkan' });
  } catch (error) {
    res.status(500).json({ message: "Server error", error });
  }
});

// Update user active status
app.put('/admin/users/:id/status', async (req, res) => {
  try {
    const { id } = req.params;
    const { is_active } = req.body;

    await User.findByIdAndUpdate(id, { is_active, updated_at: new Date() });
    res.json({ message: 'Status diperbarui' });
  } catch (error) {
    res.status(500).json({ message: "Server error", error });
  }
});

// Delete user
app.delete('/admin/users/:id', async (req, res) => {
  try {
    const { id } = req.params;
    await User.findByIdAndDelete(id);
    res.json({ message: 'User dihapus' });
  } catch (error) {
    res.status(500).json({ message: "Server error", error });
  }
});

// -------------------- START SERVER --------------------
app.listen(PORT, () => {
  console.log(`🚀 Server running on http://localhost:${PORT}`);
});
