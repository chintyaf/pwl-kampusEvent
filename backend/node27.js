const express = require("express");
const mongoose = require("mongoose");
const cors = require("cors");
const bodyParser = require("body-parser");
const bcrypt = require("bcryptjs");

const app = express();
const PORT = 3000;

// ========== MIDDLEWARE ==========
app.use(cors());
app.use(bodyParser.json());

// ========== MONGODB CONNECTION ==========
mongoose.connect("mongodb://localhost:27017/evoria")
  .then(() => console.log("✅ MongoDB connected"))
  .catch(err => console.error("❌ MongoDB connection error:", err));

// ========== USER SCHEMA ==========
const userSchema = new mongoose.Schema({
  name: { type: String, required: true },
  email: { type: String, required: true, unique: true },
  password: { type: String, required: true },
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

// ========== ROUTES ==========

// REGISTER MEMBER
app.post('/register', async (req, res) => {
  const { name, email, password } = req.body;

  if (!name || !email || !password) {
    return res.status(400).json({ message: "Semua field harus diisi" });
  }

  const existing = await User.findOne({ email });
  if (existing) return res.status(409).json({ message: "Email sudah terdaftar" });

  const hashedPassword = await bcrypt.hash(password, 10);

  // ✅ Cek apakah ada admin
  const adminExists = await User.exists({ role: "admin" });

  const user = new User({
    name,
    email,
    password: hashedPassword,
    role: adminExists ? 'member' : 'admin', // 🎯 Admin pertama kali!
    is_active: true
  });

  await user.save();
  res.json({
    message: adminExists
      ? 'Registrasi member berhasil'
      : 'Registrasi admin pertama berhasil (karena belum ada admin)'
  });
});


// LOGIN
app.post("/login", async (req, res) => {
  const { email, password } = req.body;

  if (!email || !password) return res.status(400).json({ message: "Email dan password wajib diisi" });

  try {
    const user = await User.findOne({ email });
    if (!user) return res.status(401).json({ message: "User tidak ditemukan" });

    const validPassword = await bcrypt.compare(password, user.password);
    if (!validPassword) return res.status(401).json({ message: "Password salah" });

    if (!user.is_active) return res.status(403).json({ message: "Akun nonaktif" });

    res.status(200).json({
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

// GET USERS FOR ADMIN
app.get('/admin/users', async (req, res) => {
  try {
    const users = await User.find({
      role: { $in: ['finance_team', 'event_committee'] }
    });
    res.json(users);
  } catch (error) {
    res.status(500).json({ message: "Gagal mengambil data user", error });
  }
});

// ADD USER BY ADMIN
app.post('/admin/users', async (req, res) => {
  const { name, email, password, role } = req.body;

  if (!name || !email || !password || !role) {
    return res.status(400).json({ message: "Semua field wajib diisi" });
  }

  if (!["finance_team", "event_committee", "event_staff", "member"].includes(role)) {
    return res.status(400).json({ message: "Role tidak valid" });
  }

  try {
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
    res.status(201).json({ message: 'User berhasil ditambahkan' });
  } catch (error) {
    res.status(500).json({ message: "Gagal menambahkan user", error });
  }
});

// UPDATE USER STATUS
app.put('/admin/users/:id/status', async (req, res) => {
  const { id } = req.params;
  const { is_active } = req.body;

  try {
    const updated = await User.findByIdAndUpdate(id, {
      is_active,
      updated_at: new Date()
    });

    if (!updated) return res.status(404).json({ message: "User tidak ditemukan" });

    res.json({ message: 'Status user berhasil diperbarui' });
  } catch (error) {
    res.status(500).json({ message: "Gagal memperbarui status", error });
  }
});

// DELETE USER
app.delete('/admin/users/:id', async (req, res) => {
  const { id } = req.params;

  try {
    const deleted = await User.findByIdAndDelete(id);
    if (!deleted) return res.status(404).json({ message: "User tidak ditemukan" });

    res.json({ message: 'User berhasil dihapus' });
  } catch (error) {
    res.status(500).json({ message: "Gagal menghapus user", error });
  }
});

// ========== START SERVER ==========
app.listen(PORT, () => {
  console.log(`🚀 Server running on http://localhost:${PORT}`);
});
