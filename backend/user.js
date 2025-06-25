// Example of creating a user with role in Node.js (MongoDB)

const express = require('express');
const bcrypt = require('bcrypt');
const User = require('./models/User'); // Assuming a User model is available

const router = express.Router();

router.post('/admin/users/finance', async (req, res) => {
    const { name, email, password, role } = req.body;

    // Ensure role is 'finance_team'
    if (role !== 'finance_team') {
        return res.status(400).json({ message: 'Invalid role' });
    }

    try {
        const hashedPassword = await bcrypt.hash(password, 10);
        const newUser = new User({
            name,
            email,
            password: hashedPassword,
            role,  // This should be 'finance_team'
            is_active: true
        });

        await newUser.save();
        return res.status(201).json({ message: 'User created successfully' });

    } catch (error) {
        return res.status(500).json({ message: 'Error creating user', error });
    }
});

// The same route for 'event_committee' role
router.post('/admin/users/committee', async (req, res) => {
    const { name, email, password, role } = req.body;

    // Ensure role is 'event_committee'
    if (role !== 'event_committee') {
        return res.status(400).json({ message: 'Invalid role' });
    }

    try {
        const hashedPassword = await bcrypt.hash(password, 10);
        const newUser = new User({
            name,
            email,
            password: hashedPassword,
            role,  // This should be 'event_committee'
            is_active: true
        });

        await newUser.save();
        return res.status(201).json({ message: 'User created successfully' });

    } catch (error) {
        return res.status(500).json({ message: 'Error creating user', error });
    }
});

module.exports = router;
