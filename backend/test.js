const express = require("express");
const multer = require("multer");
const unzipper = require("unzipper");
const fs = require("fs-extra");
const path = require("path");
const cors = require("cors");

const app = express();
app.use(cors());

const upload = multer({ dest: "uploads/" });

app.post("/upload-zip", upload.single("zipFile"), async (req, res) => {
    const zipPath = req.file.path;
    const extractDir = `certificates/${Date.now()}`;

    await fs.ensureDir(extractDir);

    // Unzip and extract
    const zipStream = fs
        .createReadStream(zipPath)
        .pipe(unzipper.Extract({ path: extractDir }));

    zipStream.on("close", async () => {
        const files = await fs.readdir(extractDir);
        const pdfFiles = files.filter((f) => f.endsWith(".pdf"));

        const metadata = pdfFiles.map((filename) => {
            // Example: 12345_JohnDoe.pdf
            const base = path.basename(filename, ".pdf");
            const [userId, ...nameParts] = base.split("_");
            return {
                file: filename,
                userId,
                userName: nameParts.join(" "),
            };
        });

        console.log("Uploaded Certificates:", metadata);

        // Optionally: save to DB or move to permanent storage

        fs.unlinkSync(zipPath); // cleanup uploaded ZIP
        res.json({
            message: `Uploaded ${pdfFiles.length} certificates.`,
            details: metadata,
        });
    });

    try {
        // await fs.ensureDir(extractDir);
        // // Unzip and extract
        // const zipStream = fs
        //     .createReadStream(zipPath)
        //     .pipe(unzipper.Extract({ path: extractDir }));
        // zipStream.on("close", async () => {
        //     const files = await fs.readdir(extractDir);
        //     const pdfFiles = files.filter((f) => f.endsWith(".pdf"));
        //     const metadata = pdfFiles.map((filename) => {
        //         // Example: 12345_JohnDoe.pdf
        //         const base = path.basename(filename, ".pdf");
        //         const [userId, ...nameParts] = base.split("_");
        //         return {
        //             file: filename,
        //             userId,
        //             userName: nameParts.join(" "),
        //         };
        //     });
        //     console.log("Uploaded Certificates:", metadata);
        //     // Optionally: save to DB or move to permanent storage
        //     fs.unlinkSync(zipPath); // cleanup uploaded ZIP
        //     res.json({
        //         message: `Uploaded ${pdfFiles.length} certificates.`,
        //         details: metadata,
        //     });
        // });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Error processing ZIP upload." });
    }
});

app.listen(3000, () =>
    console.log("Server listening on http://localhost:3000")
);
