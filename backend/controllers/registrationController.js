const mongoose = require('mongoose');
const Registration = require('../models/Registration'); // Import the Registration model
const User = require('../models/User'); // Import the User model
const Event = require('../models/Event'); // Import the Event model

// Create a registration
exports.createRegistration = async (req, res) => {
    const { eventId, memberId, memberName, memberEmail, paymentAmount } = req.body;

    try {
        // Validate that the event and user exist
        const event = await Event.findById(eventId);
        const user = await User.findById(memberId);

        if (!event) {
            return res.status(404).json({ message: "Event not found" });
        }
        if (!user) {
            return res.status(404).json({ message: "User not found" });
        }

        // Create new registration
        const registration = new Registration({
            eventId,
            memberId,
            memberName,
            memberEmail,
            paymentAmount,
            paymentStatus: 'pending', // Default payment status
        });

        await registration.save();

        res.status(201).json({
            message: "Registration created successfully",
            registration
        });

    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Server error", error: err });
    }
};

// Get all registrations
exports.getAllRegistrations = async (req, res) => {
    try {
        const registrations = await Registration.find()
            .populate('eventId', 'name') // Populate event details
            .populate('memberId', 'name email'); // Populate member details

        res.status(200).json({ registrations });

    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Server error", error: err });
    }
};

// Update payment status
exports.updatePaymentStatus = async (req, res) => {
    const { registrationId, paymentStatus, paymentProof, paymentDate } = req.body;

    try {
        const registration = await Registration.findById(registrationId);

        if (!registration) {
            return res.status(404).json({ message: "Registration not found" });
        }

        registration.paymentStatus = paymentStatus;
        registration.paymentProof = paymentProof || registration.paymentProof; // Update payment proof if provided
        registration.paymentDate = paymentDate || registration.paymentDate; // Update payment date if provided

        // If payment is verified
        if (paymentStatus === 'verified') {
            registration.verifiedBy = req.user.id; // Assuming user is authenticated
            registration.verifiedAt = new Date();
        }

        await registration.save();

        res.status(200).json({ message: "Payment status updated successfully", registration });

    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Server error", error: err });
    }
};
