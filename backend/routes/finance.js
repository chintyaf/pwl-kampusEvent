const express = require('express');
const router = express.Router();
const Registration = require('../models/registration');
const User = require('../models/User');
const Event = require('../models/Event');
// const Event = require('../models/EventRegister');

// GET: Semua pendaftar dengan info user dan event
// router.get('/registrations', async (req, res) => {
//   try {
//     const data = await Registration.find()
//       .populate('userId', 'name email') // ambil nama dan email user
//       .populate('eventId', 'title');    // ambil nama event
//     res.json(data);
//   } catch (err) {
//     res.status(500).json({ error: 'Failed to fetch data' });
//   }
// });

// // PUT: Update status pembayaran
// router.put('/registrations/:id/payment-status', async (req, res) => {
//   const { paymentStatus } = req.body;
//   try {
//     const reg = await Registration.findByIdAndUpdate(
//       req.params.id,
//       { paymentStatus },
//       { new: true }
//     );
//     res.json({ message: 'Status updated', registration: reg });
//   } catch (err) {
//     res.status(500).json({ error: 'Failed to update status' });
//   }
// });

router.get('/server-rendered/finance/registrations', async (req, res) => {
  const registrations = await Registration.find()
    .populate('userId', 'name email')
    .populate('eventId', 'title')
    .lean();
  res.json(registrations);
});

router.put('/server-rendered/finance/registrations/:id/payment-status', async (req, res) => {
  const { id } = req.params;
  const { paymentStatus } = req.body;

  await Registration.findByIdAndUpdate(id, { paymentStatus });
  res.json({ message: 'Status updated successfully' });
});
module.exports = router;
