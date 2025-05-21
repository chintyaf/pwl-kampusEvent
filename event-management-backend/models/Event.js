const mongoose = require('mongoose');

const EventSchema = new mongoose.Schema({
  name: {
    type: String,
    required: true
  },
  date: {
    type: Date,
    required: true
  },
  time: {
    type: String,
    required: true
  },
  location: {
    type: String,
    required: true
  },
  speaker: {
    type: String,
    required: true
  },
  poster_url: {
    type: String
  },
  registration_fee: {
    type: Number,
    required: true
  },
  max_participants: {
    type: Number,
    required: true
  },
  total_participants: {
    type: Number,
    default: 0
  },
  created_at: {
    type: Date,
    default: Date.now
  },
  updated_at: {
    type: Date,
    default: Date.now
  }
});

module.exports = mongoose.model('Event', EventSchema);