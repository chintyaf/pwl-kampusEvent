const express = require('express');
const mongoose = require('mongoose');
const bcrypt = require('bcryptjs');
const cors = require('cors');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// MongoDB Connection
mongoose.connect('mongodb://localhost:27017/your_database_name', {
    useNewUrlParser: true,
    useUnifiedTopology: true
});

// User Schema
const userSchema = new mongoose.Schema({
    name: {
        type: String,
        required: true
    },
    email: {
        type: String,
        required: true,
        unique: true
    },
    password: {
        type: String,
        required: true
    },
    role: {
        type: String,
        enum: ['member', 'finance_team', 'event_committee', 'admin'],
        default: 'member'
    },
    status: {
        type: String,
        enum: ['active', 'inactive'],
        default: 'active'
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

const User = mongoose.model('User', userSchema);

// Routes

/**
 * Get all users with optional filters
 */
app.get('/api/users', async (req, res) => {
    try {
        const { role, status, search } = req.query;

        // Build filter object
        let filter = {};

        if (role && role !== '') {
            filter.role = role;
        }

        if (status && status !== '') {
            filter.status = status;
        }

        if (search && search !== '') {
            filter.$or = [
                { name: { $regex: search, $options: 'i' } },
                { email: { $regex: search, $options: 'i' } }
            ];
        }

        const users = await User.find(filter)
            .select('-password') // Exclude password from results
            .sort({ created_at: -1 })
            .lean();

        res.json({
            success: true,
            data: users,
            count: users.length
        });

    } catch (error) {
        console.error('Error fetching users:', error);
        res.status(500).json({
            success: false,
            message: 'Failed to fetch users',
            error: error.message
        });
    }
});

/**
 * Get user statistics
 */
app.get('/api/users/statistics', async (req, res) => {
    try {
        const [
            totalMembers,
            totalFinance,
            totalCommittee,
            totalActive
        ] = await Promise.all([
            User.countDocuments({ role: 'member' }),
            User.countDocuments({ role: 'finance_team' }),
            User.countDocuments({ role: 'event_committee' }),
            User.countDocuments({ status: 'active' })
        ]);

        res.json({
            success: true,
            data: {
                total_members: totalMembers,
                total_finance: totalFinance,
                total_committee: totalCommittee,
                total_active: totalActive
            }
        });

    } catch (error) {
        console.error('Error fetching statistics:', error);
        res.status(500).json({
            success: false,
            message: 'Failed to fetch statistics',
            error: error.message
        });
    }
});

/**
 * Get single user by ID
 */
app.get('/api/users/:id', async (req, res) => {
    try {
        const user = await User.findById(req.params.id)
            .select('-password')
            .lean();

        if (!user) {
            return res.status(404).json({
                success: false,
                message: 'User not found'
            });
        }

        res.json({
            success: true,
            data: user
        });

    } catch (error) {
        console.error('Error fetching user:', error);
        res.status(500).json({
            success: false,
            message: 'Failed to fetch user',
            error: error.message
        });
    }
});

/**
 * Update user status
 */
app.put('/api/users/:id/status', async (req, res) => {
    try {
        const { status } = req.body;

        if (!['active', 'inactive'].includes(status)) {
            return res.status(400).json({
                success: false,
                message: 'Invalid status value'
            });
        }

        const user = await User.findByIdAndUpdate(
            req.params.id,
            {
                status: status,
                updated_at: new Date()
            },
            { new: true }
        ).select('-password');

        if (!user) {
            return res.status(404).json({
                success: false,
                message: 'User not found'
            });
        }

        res.json({
            success: true,
            message: 'Status updated successfully',
            data: user
        });

    } catch (error) {
        console.error('Error updating user status:', error);
        res.status(500).json({
            success: false,
            message: 'Failed to update status',
            error: error.message
        });
    }
});

/**
 * Create finance team user
 */
app.post('/api/users/finance', async (req, res) => {
    try {
        const { name, email, password } = req.body;

        // Validation
        if (!name || !email || !password) {
            return res.status(400).json({
                success: false,
                message: 'Name, email, and password are required',
                errors: {
                    name: !name ? ['Name is required'] : [],
                    email: !email ? ['Email is required'] : [],
                    password: !password ? ['Password is required'] : []
                }
            });
        }

        if (password.length < 6) {
            return res.status(400).json({
                success: false,
                message: 'Password must be at least 6 characters',
                errors: {
                    password: ['Password must be at least 6 characters']
                }
            });
        }

        // Check if email already exists
        const existingUser = await User.findOne({ email });
        if (existingUser) {
            return res.status(400).json({
                success: false,
                message: 'Email already exists',
                errors: {
                    email: ['Email already exists']
                }
            });
        }

        // Hash password
        const hashedPassword = await bcrypt.hash(password, 10);

        // Create user
        const user = new User({
            name,
            email,
            password: hashedPassword,
            role: 'finance_team',
            status: 'active'
        });

        await user.save();

        // Return user without password
        const userResponse = user.toObject();
        delete userResponse.password;

        res.status(201).json({
            success: true,
            message: 'Finance team user created successfully',
            data: userResponse
        });

    } catch (error) {
        console.error('Error creating finance user:', error);

        if (error.code === 11000) {
            return res.status(400).json({
                success: false,
                message: 'Email already exists',
                errors: {
                    email: ['Email already exists']
                }
            });
        }

        res.status(500).json({
            success: false,
            message: 'Failed to create user',
            error: error.message
        });
    }
});

/**
 * Create committee user
 */
app.post('/api/users/committee', async (req, res) => {
    try {
        const { name, email, password } = req.body;

        // Validation
        if (!name || !email || !password) {
            return res.status(400).json({
                success: false,
                message: 'Name, email, and password are required',
                errors: {
                    name: !name ? ['Name is required'] : [],
                    email: !email ? ['Email is required'] : [],
                    password: !password ? ['Password is required'] : []
                }
            });
        }

        if (password.length < 6) {
            return res.status(400).json({
                success: false,
                message: 'Password must be at least 6 characters',
                errors: {
                    password: ['Password must be at least 6 characters']
                }
            });
        }

        // Check if email already exists
        const existingUser = await User.findOne({ email });
        if (existingUser) {
            return res.status(400).json({
                success: false,
                message: 'Email already exists',
                errors: {
                    email: ['Email already exists']
                }
            });
        }

        // Hash password
        const hashedPassword = await bcrypt.hash(password, 10);

        // Create user
        const user = new User({
            name,
            email,
            password: hashedPassword,
            role: 'event_committee',
            status: 'active'
        });

        await user.save();

        // Return user without password
        const userResponse = user.toObject();
        delete userResponse.password;

        res.status(201).json({
            success: true,
            message: 'Committee user created successfully',
            data: userResponse
        });

    } catch (error) {
        console.error('Error creating committee user:', error);

        if (error.code === 11000) {
            return res.status(400).json({
                success: false,
                message: 'Email already exists',
                errors: {
                    email: ['Email already exists']
                }
            });
        }

        res.status(500).json({
            success: false,
            message: 'Failed to create user',
            error: error.message
        });
    }
});

/**
 * Delete user
 */
app.delete('/api/users/:id', async (req, res) => {
    try {
        const user = await User.findById(req.params.id);

        if (!user) {
            return res.status(404).json({
                success: false,
                message: 'User not found'
            });
        }

        // Prevent deleting admin users
        if (user.role === 'admin') {
            return res.status(403).json({
                success: false,
                message: 'Cannot delete admin user'
            });
        }

        await User.findByIdAndDelete(req.params.id);

        res.json({
            success: true,
            message: 'User deleted successfully'
        });

    } catch (error) {
        console.error('Error deleting user:', error);
        res.status(500).json({
            success: false,
            message: 'Failed to delete user',
            error: error.message
        });
    }
});

// Health check endpoint
app.get('/api/health', (req, res) => {
    res.json({
        success: true,
        message: 'API is running',
        timestamp: new Date().toISOString()
    });
});

// Error handling middleware
app.use((error, req, res, next) => {
    console.error('Unhandled error:', error);
    res.status(500).json({
        success: false,
        message: 'Internal server error',
        error: error.message
    });
});

// 404 handler
app.use('*', (req, res) => {
    res.status(404).json({
        success: false,
        message: 'Endpoint not found'
    });
});

const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log(`Node.js API server running on port ${PORT}`);
    console.log(`Health check: http://localhost:${PORT}/api/health`);
});

module.exports = app;