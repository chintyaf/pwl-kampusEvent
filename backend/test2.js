const mongoose = require("mongoose");
const { SessionSchema } = require("./models/Session");

const EventSchema = new mongoose.Schema({
    name: String,
    description: String,
    session: [SessionSchema],
});

const Event = mongoose.model("Event", EventSchema);

async function main() {
    await mongoose.connect("mongodb://localhost:27017/evoria");

    const event = new Event({
        name: "Test Save",
        description: "Should appear in Compass",
        session: [
            {
                title: "Opening",
                desc: "Welcome session",
                date: new Date(),
                start_time: new Date(),
                end_time: new Date(),
                location: "Main Hall",
                max_participants: 100,
                registration_fee: 20000,
            },
        ],
    });

    console.log(event);
    await event.save();
    console.log("✅ Event saved!");
    process.exit();
}

main();
