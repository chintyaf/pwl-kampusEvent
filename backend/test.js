// index.js
const http = require("http");

const data = JSON.stringify({
    name: "John",
    email: "john@example.com",
});

const options = {
    hostname: "localhost",
    port: 3000,
    path: "/users",
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Content-Length": data.length,
    },
};

const req = http.request(options, (res) => {
    let responseBody = "";

    res.on("data", (chunk) => {
        responseBody += chunk;
    });

    res.on("end", () => {
        console.log("Response:", responseBody);
    });
});

req.on("error", (error) => {
    console.error("Error:", error);
});

req.write(data);
req.end();
