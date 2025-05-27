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

// MongoDB connection (tanpa opsi deprecated)
mongoose.connect("mongodb://localhost:27017/laravel_node")
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

// Register route (member)
app.post('/register', async (req, res) => {
  const { name, email, password } = req.body;

  if (!name || !email || !password) {
    return res.status(400).json({ message: "Semua field harus diisi" });
  }

  const existing = await User.findOne({ email });
  if (existing) return res.status(409).json({ message: "Email sudah terdaftar" });

  const hashedPassword = await bcrypt.hash(password, 10);

  const user = new User({
    name,
    email,
    password: hashedPassword,
    role: 'member'
  });

  await user.save();
  res.json({ message: 'Registrasi member berhasil' });
});

// Login route
app.post("/login", async (req, res) => {
  const { email, password } = req.body;

  try {
    const user = await User.findOne({ email });
    if (!user) return res.status(401).json({ message: "User tidak ditemukan" });

    const validPassword = await bcrypt.compare(password, user.password);
    if (!validPassword) return res.status(401).json({ message: "Password salah" });

    if (!user.is_active) return res.status(403).json({ message: "Akun nonaktif" });

    res.json({
      message: "Login berhasil",
      user: {
        name: user.name,
        email: user.email,
        role: user.role
      }
    });

  } catch (error) {
    res.status(500).json({ message: "Terjadi kesalahan server", error });
  }
});

// Get users with role finance_team or event_committee
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

// Tambah user oleh admin
app.post('/admin/users', async (req, res) => {
  try {
    const { name, email, password, role } = req.body;

    const existing = await User.findOne({ email });
    if (existing) return res.status(409).json({ message: "Email sudah digunakan" });

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

// Update status aktif user
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

// Hapus user
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
