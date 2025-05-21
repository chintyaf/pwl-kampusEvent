const mongoose = require('mongoose');

const EventRegistrationSchema = new mongoose.Schema({
  user_id: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User',
    required: true
  },
  event_id: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Event',
    required: true
  },
  registration_date: {
    type: Date,
    default: Date.now
  },
  status: {
    type: String,
    enum: ['pending', 'paid', 'cancelled', 'attended'],
    default: 'pending'
  },
  qr_code: {
    type: String
  },
  payment: {
    proof_image_url: String,
    payment_date: Date,
    status: {
      type: String,
      enum: ['waiting', 'approved', 'rejected'],
      default: 'waiting'
    },
    verified_by: {
      type: mongoose.Schema.Types.ObjectId,
      ref: 'User'
    }
  },
  attendance: {
    scanned_by: {
      type: mongoose.Schema.Types.ObjectId,
      ref: 'User'
    },
    scan_time: Date
  },
  certificate: {
    file_url: String,
    uploaded_by: {
      type: mongoose.Schema.Types.ObjectId,
      ref: 'User'
    },
    upload_date: Date
  }
});

module.exports = mongoose.model('EventRegistration', EventRegistrationSchema);