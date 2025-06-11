const mongoose = require('mongoose');

const registrationSchema = new mongoose.Schema({
  eventId: { type: mongoose.Schema.Types.ObjectId, ref: 'Event', required: true },
  userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
  paymentStatus: { 
    type: String, 
    enum: ['pending', 'paid', 'rejected'],
    default: 'pending'
  },
  paymentProof: String, // URL to payment proof image
  qrCode: String, // Generated QR code for attendance
  isAttended: { type: Boolean, default: false },
  attendedAt: Date,
  certificate: String, // URL to certificate
  registeredAt: { type: Date, default: Date.now }
});

module.exports = mongoose.model('Registration', registrationSchema);