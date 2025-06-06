const mongoose = require("mongoose");

const SpeakerSchema = new mongoose.Schema({
    name: { type: String, required: true },
    img: { type: String },
    title: { type: String },
    desc: { type: String },
});
// exports.objSchema = objSchema;

module.exports = { SpeakerSchema };
// module.exports = mongoose.model("Speaker", objSchema);
