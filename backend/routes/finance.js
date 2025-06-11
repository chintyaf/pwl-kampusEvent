// routes/finance.js
const express = require('express');
const router = express.Router();
const Registration = require('../models/Registration');
const Event = require('../models/Event');
const { authenticateToken, authorizeRole } = require('../middleware/auth');

// Get dashboard data for finance
router.get('/dashboard', authenticateToken, authorizeRole(['finance_team']), async (req, res) => {
  try {
    // Get payment statistics
    const totalRegistrations = await Registration.countDocuments();
    const paidRegistrations = await Registration.countDocuments({ paymentStatus: 'paid' });
    const pendingPayments = await Registration.countDocuments({ paymentStatus: 'pending' });
    const verifiedPayments = await Registration.countDocuments({ paymentStatus: 'verified' });
    const rejectedPayments = await Registration.countDocuments({ paymentStatus: 'rejected' });

    // Get recent payment activities
    const recentActivities = await Registration.find()
      .populate('eventId', 'name')
      .sort({ updatedAt: -1 })
      .limit(10);

    // Get payment summary by event
    const eventPaymentSummary = await Registration.aggregate([
      {
        $lookup: {
          from: 'events',
          localField: 'eventId',
          foreignField: '_id',
          as: 'event'
        }
      },
      {
        $unwind: '$event'
      },
      {
        $group: {
          _id: {
            eventId: '$eventId',
            eventName: '$event.name'
          },
          totalRegistrations: { $sum: 1 },
          paidCount: {
            $sum: { $cond: [{ $eq: ['$paymentStatus', 'paid'] }, 1, 0] }
          },
          verifiedCount: {
            $sum: { $cond: [{ $eq: ['$paymentStatus', 'verified'] }, 1, 0] }
          },
          pendingCount: {
            $sum: { $cond: [{ $eq: ['$paymentStatus', 'pending'] }, 1, 0] }
          },
          totalRevenue: {
            $sum: { $cond: [{ $in: ['$paymentStatus', ['paid', 'verified']] }, '$paymentAmount', 0] }
          }
        }
      }
    ]);

    res.json({
      success: true,
      data: {
        summary: {
          totalRegistrations,
          paidRegistrations,
          pendingPayments,
          verifiedPayments,
          rejectedPayments
        },
        recentActivities,
        eventPaymentSummary
      }
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Get all registrations with payment details
router.get('/registrations', authenticateToken, authorizeRole(['finance_team']), async (req, res) => {
  try {
    const { page = 1, limit = 10, status, eventId, search } = req.query;
    const skip = (page - 1) * limit;

    // Build filter
    let filter = {};
    if (status) filter.paymentStatus = status;
    if (eventId) filter.eventId = eventId;
    if (search) {
      filter.$or = [
        { memberName: { $regex: search, $options: 'i' } },
        { memberEmail: { $regex: search, $options: 'i' } }
      ];
    }

    const registrations = await Registration.find(filter)
      .populate('eventId', 'name eventDate registrationFee')
      .populate('verifiedBy', 'name')
      .sort({ registrationDate: -1 })
      .skip(skip)
      .limit(parseInt(limit));

    const total = await Registration.countDocuments(filter);

    res.json({
      success: true,
      data: {
        registrations,
        pagination: {
          currentPage: parseInt(page),
          totalPages: Math.ceil(total / limit),
          totalItems: total,
          itemsPerPage: parseInt(limit)
        }
      }
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Update payment status
router.put('/registrations/:id/payment-status', authenticateToken, authorizeRole(['finance_team']), async (req, res) => {
  try {
    const { id } = req.params;
    const { status, notes } = req.body;

    if (!['pending', 'paid', 'verified', 'rejected'].includes(status)) {
      return res.status(400).json({ 
        success: false, 
        message: 'Invalid payment status' 
      });
    }

    const updateData = {
      paymentStatus: status,
      notes: notes || '',
      verifiedBy: req.user.id,
      verifiedAt: new Date()
    };

    if (status === 'verified' || status === 'paid') {
      updateData.paymentDate = new Date();
    }

    const registration = await Registration.findByIdAndUpdate(
      id,
      updateData,
      { new: true }
    ).populate('eventId', 'name');

    if (!registration) {
      return res.status(404).json({ 
        success: false, 
        message: 'Registration not found' 
      });
    }

    res.json({
      success: true,
      message: 'Payment status updated successfully',
      data: registration
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Get registration details
router.get('/registrations/:id', authenticateToken, authorizeRole(['finance_team']), async (req, res) => {
  try {
    const registration = await Registration.findById(req.params.id)
      .populate('eventId', 'name eventDate registrationFee location')
      .populate('verifiedBy', 'name email');

    if (!registration) {
      return res.status(404).json({ 
        success: false, 
        message: 'Registration not found' 
      });
    }

    res.json({
      success: true,
      data: registration
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

// Bulk update payment status
router.put('/registrations/bulk-update', authenticateToken, authorizeRole(['finance_team']), async (req, res) => {
  try {
    const { registrationIds, status, notes } = req.body;

    if (!registrationIds || !Array.isArray(registrationIds)) {
      return res.status(400).json({ 
        success: false, 
        message: 'Registration IDs are required' 
      });
    }

    if (!['pending', 'paid', 'verified', 'rejected'].includes(status)) {
      return res.status(400).json({ 
        success: false, 
        message: 'Invalid payment status' 
      });
    }

    const updateData = {
      paymentStatus: status,
      notes: notes || '',
      verifiedBy: req.user.id,
      verifiedAt: new Date()
    };

    if (status === 'verified' || status === 'paid') {
      updateData.paymentDate = new Date();
    }

    const result = await Registration.updateMany(
      { _id: { $in: registrationIds } },
      updateData
    );

    res.json({
      success: true,
      message: `${result.modifiedCount} registrations updated successfully`,
      data: { modifiedCount: result.modifiedCount }
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
});

module.exports = router;