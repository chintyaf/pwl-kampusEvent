// node-app/middleware/cors.js
const corsOptions = {
  origin: 'http://localhost:8000', // URL Laravel
  credentials: true,
  methods: ['GET', 'POST', 'PUT', 'DELETE'],
  allowedHeaders: ['Content-Type', 'Authorization']
};

module.exports = corsOptions;