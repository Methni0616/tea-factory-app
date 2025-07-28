// app.js
const express = require('express');
const path = require('path');
const app = express();
require('dotenv').config();

const estateRoutes = require('./routes/estateOwnerRoutes');

app.use(express.static(path.join(__dirname, 'public')));
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

app.use('/estate-owner', estateRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
